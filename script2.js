document.addEventListener("DOMContentLoaded", function() {
    
    fetch(`calcLations.php?user_id=${user_id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById("tdeeDisplay").innerText = "Error: " + data.error;
            } else {
                document.getElementById("tdeeDisplay").innerText = `TDEE: ${data.TDEE} kcal/day`;
                document.getElementById("bMIDisplay").innerText = `BMI: ${data.BMI} kg/m2`;
                document.getElementById("clasify").innerText =
                    `Classification: ${data.BMI_CATEGORY}`;
            }
        })
        .catch(error => console.error("Error fetching TDEE:", error));
});

document.addEventListener("DOMContentLoaded", function() {

    fetch("notify.php")
        .then(response => response.json())
        .then(data => {
            if (data.reminder) {
                document.getElementById("notification").innerText = data.reminder;

            }
        })
        .catch(error => console.error("Error: ", error));
})

document.getElementById('user-menu-button').addEventListener('click', function() {
    const menu = document.getElementById('user-menu');
    menu.classList.toggle('hidden');
    menu.classList.toggle('max-h-40'); // Set a max height for smooth transition
});
document.getElementById('close-sidebar').addEventListener("click", function() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('w-64');
    sidebar.classList.toggle('w-16');
    sidebar.classList.toggle('overfow-hidden');
    const textElements = document.querySelectorAll('.sidebar-text');
    textElements.forEach(el => {
        el.classList.toggle('hidden');
        el.classList.toggle('opacity-0');
    });
})

document.addEventListener("DOMContentLoaded", function(){
    console.log("DOM fully loaded!"); // Debugging
    document.querySelectorAll('.side-link').forEach(link=>{
        link.addEventListener('click', function(e){
            e.preventDefault();
            console.log("Clicked:", this.getAttribute('data-page'));
            const page = this.getAttribute('data-page');
            console.log("Loading page:", page);
    
            fetch(page)
            .then(response => response.text())
            .then(html =>{
                document.getElementById('content').innerHTML = html;
            })
            .catch(error=>console.error('error loading page: ', error));
        })
    })
})

