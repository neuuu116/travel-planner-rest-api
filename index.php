<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Travel Planner</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
}

/* HERO */
.hero{text-align:center;padding:60px 20px;color:white;}
.hero h1{font-size:40px;font-weight:700;}
.hero p{margin-top:10px;opacity:0.9;}

/* FILTER BAR */
.filter-bar{
    background:white;
    padding:20px;
    display:flex;
    gap:15px;
    justify-content:center;
    flex-wrap:wrap;
}

.filter-bar select{
    padding:10px 15px;
    border-radius:25px;
}

/* GRID */
.container{
    padding:40px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:30px;
}

/* CARD */
.card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
    transition:0.4s;
    position:relative;
}
.card:hover{transform:translateY(-10px);}
.card img{width:100%;height:220px;object-fit:cover;}

.rating{
    position:absolute;
    top:15px;
    right:15px;
    background:#ff9800;
    color:white;
    padding:6px 12px;
    border-radius:20px;
    font-size:14px;
}

.card-content{padding:20px;}
.card-content h2{color:#1e3c72;}

.meta{font-size:14px;color:#777;margin-bottom:5px;}

.highlights{list-style:none;margin:10px 0;}
.highlights li::before{content:"✔ ";color:#4CAF50;}

.bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.price{
    font-size:20px;
    font-weight:700;
    color:#e91e63;
}

button{
    background:#1e3c72;
    color:white;
    border:none;
    padding:8px 18px;
    border-radius:20px;
    cursor:pointer;
}

button.delete{background:#e53935;}
</style>
</head>

<body>

<div class="hero">
    <h1>Explore Incredible India</h1>
    <p>Choose your perfect trip package</p>
</div>

<div class="filter-bar">
    <select id="destinationFilter">
        <option value="all">All Destinations</option>
        <option value="Kerala">Kerala</option>
        <option value="Goa">Goa</option>
        <option value="Rajasthan">Rajasthan</option>
        <option value="Andaman & Nicobar">Andaman & Nicobar</option>
    </select>

    <select id="sortOption">
        <option value="default">Sort By</option>
        <option value="priceLow">Price: Low to High</option>
        <option value="priceHigh">Price: High to Low</option>
        <option value="ratingHigh">Rating: High to Low</option>
    </select>

    <button onclick="openAddModal()">+ Add Trip</button>
</div>

<div class="container" id="packageContainer"></div>

<!-- MODAL -->
<div id="tripModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,0.6);justify-content:center;align-items:center;">

    <div style="background:white;padding:30px;border-radius:20px;width:400px;">
        <h2 id="modalTitle">Add Trip</h2>

        <input type="hidden" id="tripId">

        <input type="text" id="title" placeholder="Title" style="width:100%;margin:8px 0;padding:8px;"><br>
        <input type="text" id="destination" placeholder="Destination" style="width:100%;margin:8px 0;padding:8px;"><br>
        <input type="number" id="duration" placeholder="Duration Days" style="width:100%;margin:8px 0;padding:8px;"><br>
        <input type="number" id="price" placeholder="Price" style="width:100%;margin:8px 0;padding:8px;"><br>
        <input type="number" step="0.1" id="rating" placeholder="Rating" style="width:100%;margin:8px 0;padding:8px;"><br>
        <input type="text" id="image" placeholder="Image URL" style="width:100%;margin:8px 0;padding:8px;"><br>
        <input type="text" id="highlights" placeholder="Highlights (comma separated)" style="width:100%;margin:8px 0;padding:8px;"><br>

        <button onclick="saveTrip()">Save</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>

<script>

let allPackages = [];
const container = document.getElementById("packageContainer");

/* LOAD */
async function loadPackages(){
    const res = await fetch("api.php?action=list");
    const data = await res.json();
    allPackages = data.packages;
    renderPackages(allPackages);
}

/* RENDER */
function renderPackages(packages){
    container.innerHTML = "";
    packages.forEach(pkg=>{
        container.innerHTML += `
        <div class="card">
            <span class="rating">⭐ ${pkg.rating}</span>
            <img src="${pkg.image_url}">
            <div class="card-content">
                <h2>${pkg.title}</h2>
                <p class="meta">📍 ${pkg.destination}</p>
                <p class="meta">🗓 ${pkg.duration_days} Days</p>
                <ul class="highlights">
                    ${pkg.highlights.map(h=>`<li>${h}</li>`).join("")}
                </ul>
                <div class="bottom">
                    <span class="price">₹${Number(pkg.price).toLocaleString()}</span>
                    <div>
                        <button onclick="openEditModal(${pkg.id})">Edit</button>
                        <button class="delete" onclick="deletePackage(${pkg.id})">Delete</button>
                    </div>
                </div>
            </div>
        </div>`;
    });
}

/* DELETE */
async function deletePackage(id){
    if(!confirm("Delete this package?")) return;

    const res = await fetch("api.php",{
        method:"DELETE",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify({id:id})
    });

    const data = await res.json();
    if(data.success) loadPackages();
    else alert(data.error);
}

/* OPEN ADD */
function openAddModal(){
    document.getElementById("modalTitle").innerText="Add Trip";
    document.getElementById("tripId").value="";
    document.getElementById("tripModal").style.display="flex";
}

/* OPEN EDIT */
function openEditModal(id){
    const pkg = allPackages.find(p=>p.id==id);

    document.getElementById("modalTitle").innerText="Edit Trip";
    document.getElementById("tripId").value=id;
    document.getElementById("title").value=pkg.title;
    document.getElementById("destination").value=pkg.destination;
    document.getElementById("duration").value=pkg.duration_days;
    document.getElementById("price").value=pkg.price;
    document.getElementById("rating").value=pkg.rating;
    document.getElementById("image").value=pkg.image_url;
    document.getElementById("highlights").value=pkg.highlights.join(",");

    document.getElementById("tripModal").style.display="flex";
}

/* CLOSE */
function closeModal(){
    document.getElementById("tripModal").style.display="none";
}

/* SAVE */
async function saveTrip(){

    const id = document.getElementById("tripId").value;

    const tripData={
        id:id,
        title:document.getElementById("title").value,
        destination:document.getElementById("destination").value,
        duration_days:document.getElementById("duration").value,
        price:document.getElementById("price").value,
        rating:document.getElementById("rating").value,
        image_url:document.getElementById("image").value,
        highlights:document.getElementById("highlights").value.split(",")
    };

    const res = await fetch("api.php",{
        method: id ? "PUT" : "POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify(tripData)
    });

    const data = await res.json();

    if(data.success){
        closeModal();
        loadPackages();
    } else {
        alert(data.error);
    }
}

/* FILTER */
document.getElementById("destinationFilter").addEventListener("change",function(){
    const v=this.value;
    renderPackages(v==="all"?allPackages:allPackages.filter(p=>p.destination===v));
});

/* SORT */
document.getElementById("sortOption").addEventListener("change",function(){
    let sorted=[...allPackages];
    if(this.value==="priceLow") sorted.sort((a,b)=>a.price-b.price);
    if(this.value==="priceHigh") sorted.sort((a,b)=>b.price-a.price);
    if(this.value==="ratingHigh") sorted.sort((a,b)=>b.rating-a.rating);
    renderPackages(sorted);
});

loadPackages();

</script>

</body>
</html>