$(document).ready(function() {
    $("#phoneNumber").on("blur", function() {
        let phoneNumber = $("#phoneNumber").val().trim();
        // Validate phone number (must be 10 digits)
        if (!/^\d{10}$/.test(phoneNumber)) {
            $("#phoneNumber").val(""); // Clear invalid input
            return;
        }

        if (phoneNumber) {
            // AJAX request to check if patient exists
            $.ajax({
                url: "/patients/checkPatient", // Your endpoint to check patient
                type: "GET",
                data: { phone_number: phoneNumber },
                success: function(response) {
                    if (response.exists) {
                        // If patient exists, auto-fill the form with existing patient data (if needed)
                        // Optionally you can show an alert or just proceed to booking the appointment
                        $("#patientId").val(response.patient.id);
                        $("#newPatientDetails").hide();
                    } else {
                        // If patient doesn't exist, show the form to input new details
                        $("#newPatientDetails").show();
                        $("#patientId").val("");
                    }
                },
                error: function() {
                    alert("Error checking patient.");
                }
            });
        }
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
            phone_number: phoneNumber,
            appointment_type: appointmentType,
            email: patientEmail
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
