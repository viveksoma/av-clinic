$(document).ready(function() {
    $("#phoneNumber").on("blur", function () {
        let phoneNumber = $(this).val().trim();

        if (!/^\d{10}$/.test(phoneNumber)) {
            $(this).val("");
            return;
        }

        $.ajax({
            url: "/patients/checkPatient",
            type: "GET",
            data: { phone_number: phoneNumber },
            success: function (response) {

                $("#existingPatients").empty()
                    .append(`<option value="">Select Patient</option>`);

                if (response.exists && response.patients.length > 0) {

                    // Show existing patients dropdown
                    $("#existingPatientsWrapper").show();
                    $("#newPatientDetails").hide();

                    response.patients.forEach(patient => {
                        $("#existingPatients").append(`
                            <option value="${patient.id}">
                                ${patient.name} (Age: ${patient.age})
                            </option>
                        `);
                    });

                } else {
                    // No patients → show new patient form
                    $("#existingPatientsWrapper").hide();
                    $("#newPatientDetails").show();
                    $("#patientId").val("");
                }
            },
            error: function () {
                alert("Error checking patient.");
            }
        });
    });

    $("#existingPatients").on("change", function () {
        let patientId = $(this).val();

        if (patientId) {
            $("#patientId").val(patientId);
            $("#newPatientDetails").hide();
        } else {
            $("#patientId").val("");
        }
    });

    $("#addNewPatientBtn").on("click", function () {
        $("#existingPatients").val("");
        $("#patientId").val("");
        $("#newPatientDetails").show();
    });


    $("#doctorSelect, #appointmentDate").on("change", function() {
        let doctor_id = $("#doctorSelect").val();
        let date = $("#appointmentDate").val();

        if (doctor_id && date) {
            $.ajax({
                url: "/appointments/getSlots",  // Get available slots for the doctor on the selected date
                type: "GET",
                data: { doctor_id, date },
                success: function(response) {
                    let morningSlotsContainer = $("#morningSlotsContainer");
                    let eveningSlotsContainer = $("#eveningSlotsContainer");

                    morningSlotsContainer.empty();
                    eveningSlotsContainer.empty();

                    $("#avialableSlots").show();
                    let morningSlots = response.morning_slots;
                    let eveningSlots = response.evening_slots;

                    // Fetch the booked slots once for the selected doctor and date
                    $.ajax({
                        url: "/appointments/getBookedSlots",  // New endpoint to fetch booked slots for doctor and date
                        type: "GET",
                        data: { doctor_id, date },
                        success: function(bookedResponse) {
                            let bookedSlots = bookedResponse.booked_slots;

                            // Render morning slots
                            if (morningSlots.length > 0) {
                                morningSlots.forEach(slot => {
                                    const buttonHTML = `
                                        <button class="btn btn-outline-primary slot-btn" data-time="${slot}" 
                                                ${isSlotBooked(slot, bookedSlots) ? 'disabled' : ''}>${slot}</button>
                                    `;
                                    morningSlotsContainer.append(buttonHTML);
                                });
                            } else {
                                morningSlotsContainer.append("<p class='text-danger'>No available morning slots</p>");
                            }

                            // Render evening slots
                            if (eveningSlots.length > 0) {
                                eveningSlots.forEach(slot => {
                                    const buttonHTML = `
                                        <button class="btn btn-outline-primary slot-btn" data-time="${slot}" 
                                                ${isSlotBooked(slot, bookedSlots) ? 'disabled' : ''}>${slot}</button>
                                    `;
                                    eveningSlotsContainer.append(buttonHTML);
                                });
                            } else {
                                eveningSlotsContainer.append("<p class='text-danger'>No available evening slots</p>");
                            }
                        },
                        error: function() {
                            console.log("Error fetching booked slots");
                        }
                    });
                },
                error: function() {
                    console.log("Error fetching available slots");
                }
            });
        }
    });

    // Select Slot
    $(document).on("click", ".slot-btn", function() {
        $(".slot-btn").removeClass("btn-primary").addClass("btn-outline-primary");
        $(this).removeClass("btn-outline-primary").addClass("btn-primary");
        $("#bookAppointment").prop("disabled", false).data("time", $(this).data("time"));
    });

    let originalDoctorOptions = $("#doctorSelect").html(); // store full list for reset

    $("#appointmentType").on("change", function () {
        const selectedType = $(this).val();

        $.get('/admin/doctors/by-type', { type: selectedType }, function (doctors) {
            let options = '<option value="">Select Doctor</option>';

            doctors.forEach(doctor => {
                options += `<option value="${doctor.id}">
                    ${doctor.name}
                </option>`;
            });

            $("#doctorSelect").html(options);
        });
    });


    function calculateAge(dob) {
        const birthDate = new Date(dob);
        const today = new Date();

        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    $('#patientDob').on('change', function () {
        const dob = $(this).val();
        if (!dob) return;

        const age = calculateAge(dob);
        $('#patientAge').val(age + ' years');

        if (age < 18) {
            $('#guardianFields').slideDown();
        } else {
            $('#guardianFields').slideUp();
            $('#guardianName').val('');
            $('#guardianRelation').val('');
        }
    });

    $(document).ready(function () {
        let flatpickrInstance = null;

        let dayMap = {
            'Sunday': 0,
            'Monday': 1,
            'Tuesday': 2,
            'Wednesday': 3,
            'Thursday': 4,
            'Friday': 5,
            'Saturday': 6
        };

        $("#doctorSelect").on("change", function () {
            let doctorId = $(this).val();
            if (doctorId) {
                $.get("/appointments/getDoctorAvailableDays", { doctor_id: doctorId }, function (response) {
                    let availableDays = response.available_days || [];

                    if (flatpickrInstance) {
                        flatpickrInstance.destroy();
                    }

                    if (availableDays.length > 0) {
                        let enabledDays = availableDays.map(day => dayMap[day]);

                        flatpickrInstance = flatpickr("#appointmentDate", {
                            dateFormat: "Y-m-d",
                            minDate: "today",
                            disable: [
                                function (date) {
                                    return !enabledDays.includes(date.getDay());
                                }
                            ]
                        });
                    } else {
                        // No restriction – enable all days
                        flatpickrInstance = flatpickr("#appointmentDate", {
                            dateFormat: "Y-m-d",
                            minDate: "today"
                        });
                    }
                });
            }
        });
    });


    // Book Appointment
    $("#bookAppointment").on("click", function () {
        let $btn = $(this);
        let originalText = $btn.html();
        let $status = $("#appointmentStatus");
        $status.html(""); // Clear previous messages
    
        // Set loading state
        $btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Booking...');
    
        let doctor_id = $("#doctorSelect").val();
        let date = $("#appointmentDate").val();
        let appointmentType = $("#appointmentType").val();
        let time = $btn.data("time");
        let phoneNumber = $("#phoneNumber").val().trim();
        let patientName = $("#patientName").val().trim();
        let patientAge = $("#patientAge").val().trim();
        let patientId = $("#patientId").val();
        let patientEmail = $("#patientEmail").val();
        let guardianName = $("#guardianName").val();
        let guardianRelation = $("#guardianRelation").val();
        let patientDob = $("#patientDob").val();
    
        // Validate phone number
        if (!/^\d{10}$/.test(phoneNumber)) {
            showMessage("Please enter a valid 10-digit phone number.", "danger");
            resetButton();
            return;
        }
    
        if (!doctor_id || !date || !time || !appointmentType) {
            showMessage("Please select doctor, date, and time for the appointment.", "danger");
            resetButton();
            return;
        }
    
        let requestData = {
            doctor_id,
            date,
            time,
            dob: patientDob,
            phone_number: phoneNumber,
            appointment_type: appointmentType,
            email: patientEmail,
            guardian_relation: guardianRelation,
            guardian_name: guardianName
        };
    
        if (patientId) {
            requestData.patient_id = patientId;
        } else {
            if (!patientName || !patientAge) {
                showMessage("Please enter patient name and age.", "danger");
                resetButton();
                return;
            }
            requestData.patient_name = patientName;
            requestData.patient_age = patientAge;
        }
    
        $.ajax({
            url: "/appointments/book",
            type: "POST",
            data: requestData,
            success: function (response) {
                showMessage("Appointment booked successfully!", "success");
                resetButton();

                setTimeout(() => {
                    location.reload(); // 🔄 refresh page
                }, 1500); // 1.5 sec delay
            },
            error: function () {
                showMessage("Error booking appointment!", "danger");
                resetButton();
            }
        });
    
        function resetButton() {
            $btn.prop("disabled", false).html(originalText);
        }
    
        function showMessage(msg, type = "info") {
            $status.html(`<div class="badge bg-${type} p-2">${msg}</div>`);
            setTimeout(() => {
                $status.fadeOut(500, function () {
                    $(this).html("").show();
                });
            }, 3000);
        }
    });    

});

// Function to check if a slot is booked
function isSlotBooked(slot, bookedSlots) {
    return bookedSlots.includes(slot);
}
