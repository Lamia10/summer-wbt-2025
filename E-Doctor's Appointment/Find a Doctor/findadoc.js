function filterDoctors() {
    let nameInput = document.getElementById("nameSearch").value.toLowerCase();
    let deptInput = document.getElementById("departmentFilter").value.toLowerCase();
    let doctors = document.querySelectorAll(".doctor-card");

    doctors.forEach(doc => {
        let name = doc.getAttribute("data-name").toLowerCase();
        let department = doc.getAttribute("data-department").toLowerCase();

        if (
            (name.includes(nameInput) || nameInput === "") &&
            (department.includes(deptInput) || deptInput === "")
        ) {
            doc.style.display = "block";
        } else {
            doc.style.display = "none";
        }
    });
}
