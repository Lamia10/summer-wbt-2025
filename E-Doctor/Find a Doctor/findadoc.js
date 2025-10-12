// Get inputs
const nameInput = document.getElementById("nameSearch");
const deptInput = document.getElementById("departmentFilter");

// Function to filter doctors
function filterDoctors() {
    let nameVal = nameInput.value.toLowerCase();
    let deptVal = deptInput.value.toLowerCase();
    let doctors = document.querySelectorAll(".doctor-card");

    doctors.forEach(doc => {
        let name = doc.getAttribute("data-name").toLowerCase();
        let department = doc.getAttribute("data-department").toLowerCase();

        if (
            (name.includes(nameVal) || nameVal === "") &&
            (department.includes(deptVal) || deptVal === "")
        ) {
            doc.style.display = "block";
        } else {
            doc.style.display = "none";
        }
    });
}

// Event listeners for live filtering
nameInput.addEventListener("input", filterDoctors);
deptInput.addEventListener("change", filterDoctors);

// Optional: filter on page load in case URL has pre-filled values
window.addEventListener("DOMContentLoaded", filterDoctors);
