# Travel Planner - Trip Packages

A simple PHP/MySQL application for managing trip packages. Similar to MakeMyTrip's holiday packages section.

---

## P.S. - Student Assignment

### What is this application?
Travel Planner is a web application where users can browse, search, and manage trip packages. It consists of:
- **Frontend**: HTML/CSS/JS interface with a card grid layout
- **Backend**: PHP API for CRUD operations (Create, Read, Delete)
- **Database**: MySQL to store trip packages

### Your Tasks

As part of the hackathon, you need to implement the following mandatory tasks:

1. **Build the Frontend UI** (`index.html`)
   - Create a responsive card grid layout to display trip packages
   - Add a search bar to filter packages by destination/title
   - Implement a modal popup to view package details when clicking a card
   - Add a form modal to create new trip packages
   - Style it with CSS (gradients, shadows, responsive design)

2. **Implement DELETE API** (`api.php`)
   - The TODO comment in `api.php` guides you on what to implement
   - Add a DELETE endpoint to remove trip packages by ID
   - Handle proper validation and error responses

3. **Sky’s the Limit – Create your own features** (Optional)
   - Add any additional features you want to implement
   - Use your creativity to make the application better

### What you're given:
- `schema.sql` - Database structure (run this first)
- `seed.sql` - Sample data with 5 trip packages
- `config.php` - Database connection settings
- `api.php` - Partial API with GET (list, search, get by ID) and POST (create) already implemented, plus a TODO for DELETE

---

## Prerequisites

- XAMPP installed (Apache + MySQL)

---

## Step 1: Start XAMPP

### Linux

```bash
cd /opt/lampp
sudo ./lampp start
```

### Windows

1. Open **XAMPP Control Panel**
2. Click **Start** button next to **Apache**
3. Click **Start** button next to **MySQL**

---

## Step 2: Create the Database

1. Open browser and go to: **http://localhost/phpmyadmin**

2. Click the **SQL** tab

3. Copy and paste the contents of `schema.sql` to create the database and table

4. Click **Go** button

5. Click **SQL** tab again

6. Copy and paste the contents of `seed.sql` to add sample trip packages

7. Click **Go** button

---

## Step 3: Run the Application

Open a terminal in the `travel-planner` directory:

```bash
cd travel-planner
php -S localhost:8000
```

---

## Step 4: Open in Browser

Visit: **http://localhost:8000**

You should see the Travel Planner (once you've built the frontend) with sample trip packages!

---

## API Endpoints (For Reference)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `api.php?action=list` | Get all packages |
| GET | `api.php?action=get&id=1` | Get single package |
| GET | `api.php?action=search&q=kerala` | Search packages |
| POST | `api.php` | Create new package |
| DELETE | `api.php` | Delete package (TODO: Implement this!) |

### POST Request Body Format:
```json
{
    "title": "Kerala Backwaters Bliss",
    "destination": "Kerala",
    "duration_days": 5,
    "price": 24999,
    "image_url": "https://example.com/image.jpg",
    "highlights": ["Houseboat Stay", "Alleppey Backwaters", "Sunset Cruise"]
}
```

### DELETE Request Body Format (to be implemented):
```json
{
    "id": 5
}
```

---

## Files in this Directory

| File | Purpose |
|------|---------|
| `schema.sql` | Creates database and trip_packages table |
| `seed.sql` | Inserts 5 sample trip packages |
| `config.php` | Database connection settings |
| `api.php` | API endpoints (partial - GET and POST done, DELETE TODO) |
| `index.html` | Frontend interface (to be built by you) |

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| "Database connection failed" | Make sure MySQL is running in XAMPP Control Panel |
| "Access denied for user" | Check `config.php` - default XAMPP is username: `root`, password: empty |
| Port 8000 already in use | Use a different port: `php -S localhost:8080` |

---

## Tips for Implementation

### Frontend Tips:
- Use CSS Grid for the card layout (`grid-template-columns: repeat(auto-fill, minmax(320px, 1fr))`)
- Use `fetch()` API to call the PHP backend
- For modals, use a fixed overlay with `display: none/block` or a CSS class toggle
- Remember to prevent event bubbling when clicking inside modals

### DELETE API Tips:
- Check `$method === 'DELETE'` to handle DELETE requests
- Use `json_decode(file_get_contents('php://input'), true)` to read the request body
- Use prepared statements (`$conn->prepare()`) for security
- Check `$stmt->affected_rows` to confirm deletion

Good luck!
