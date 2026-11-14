# Elite Auto Care

A web application for smart vehicle servicing. Customers register their vehicles, get **AI-generated maintenance recommendations** (with price estimates in LKR) based on their mileage, and manage everything from a single dashboard.

> Developed as a group project for the **IT Project Management** module (2nd year, 2nd semester) at the University of Colombo School of Computing (UCSC).

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Architecture](#architecture)
- [Project Structure](#project-structure)
- [Routes](#routes)
- [Database](#database)
- [Getting Started](#getting-started)
- [Configuration](#configuration)
- [Project Status and Roadmap](#project-status-and-roadmap)
- [Team](#team)

---

## Features

**For visitors**
- Landing page with hero section, About Us, Our Services, How It Works, and a WhatsApp contact link
- Two-step sign-up modal: account details first, then the customer's first vehicle
- Login modal with clear error messages for unknown email or wrong password

**For registered customers**
- **Dashboard**: personalised welcome, vehicle count, service count, vehicle status cards, and quick-action shortcuts
- **My Vehicles**: add, edit, and delete vehicles, with optional photo upload. Every query is scoped to the logged-in user, so customers can only touch their own vehicles
- **Book a Service**: enter the current mileage and receive 3-4 prioritised service recommendations (high / medium / low) with a reason and an estimated cost in Sri Lankan Rupees
- **Service History**: status-tabbed view (All, Pending, Approved, Completed, Cancelled)
- Responsive layout with a mobile navigation drawer, and a custom 404 page

**Validation and security**
- Email format and uniqueness checks; passwords must be at least 8 characters and match the confirmation
- Passwords stored with `password_hash()` and checked with `password_verify()`
- Sri Lankan plate-number format enforced (e.g. `CAR-1234`: 2-3 capital letters, a hyphen, 4 digits) with a uniqueness check
- PDO prepared statements for all database access, and per-model column whitelists (`allowedColumns`) on inserts and updates
- Output escaping when rendering AI-generated text in the browser

### How the AI recommendations work

1. The customer enters their current mileage on the Book Service page.
2. The page sends it to `BookService/getRecommendations`, which calculates the distance since the last recorded service.
3. The server builds a prompt (including typical Sri Lankan service prices as reference) and calls the [OpenRouter](https://openrouter.ai) chat-completions API using the free `cognitivecomputations/dolphin3.0-r1-mistral-24b` model.
4. The response is parsed as a JSON array of `{name, priority, reason, price}`. If the model returns extra text, the JSON is extracted from it. Missing or malformed prices are normalised, with priority-based fallbacks.
5. A mileage gap under 100 km is treated as a likely data-entry error or a very recent service, and the prompt asks for inspection-only advice.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP (custom MVC framework, no external dependencies) |
| Database | MySQL accessed through PDO |
| Frontend | HTML, CSS, vanilla JavaScript |
| UI assets | Google Fonts (Poppins), Font Awesome 6 |
| AI | OpenRouter API (called with cURL) |
| Web server | Apache with `mod_rewrite` |

---

## Architecture

The app follows the **MVC** pattern with a small hand-built core:

```
Browser -> public/index.php -> App (router) -> Controller -> Model -> MySQL
                                                    |
                                                  View (.view.php)
```

- **Front controller**: `public/index.php` starts the session and boots the app. `public/.htaccess` rewrites every request that isn't a real file to `index.php?url=...`.
- **Router** (`app/core/App.php`): maps `/Controller/method/param1/param2` to a controller class and method, and falls back to the `_404` controller when either does not exist.
- **Controller base** (`app/core/Controller.php`): provides `view()` and `loadModel()`.
- **Model trait** (`app/core/Model.php`): reusable `selectALL`, `where` (supports `>=`, `<=`, `>`, `<`, `!=`, ordering, limit, offset), `first`, `insert`, `update`, and `delete`. Each model only declares its table name and allowed columns.
- **Database trait** (`app/core/Database.php`): a lazily created, shared PDO connection with `query()` and `get_row()` helpers.

---

## Project Structure

```
eliteAutoCareFinal/
├── app/
│   ├── controllers/
│   │   ├── Home.php                 # landing page, signup, login, logout
│   │   ├── RegisteredUserHome.php   # customer dashboard
│   │   ├── MyVehicles.php           # vehicle CRUD + image upload
│   │   ├── BookService.php          # mileage input + AI recommendations
│   │   ├── ServiceHistory.php       # service history page
│   │   └── _404.php                 # not-found handler
│   ├── core/
│   │   ├── App.php                  # router
│   │   ├── Controller.php           # base controller
│   │   ├── Database.php             # PDO connection trait
│   │   ├── Model.php                # generic query-builder trait
│   │   ├── config.php               # URLs and database settings
│   │   ├── functions.php            # helpers: show(), esc(), redirect()
│   │   └── init.php                 # autoloader + core includes
│   ├── models/
│   │   ├── UserModel.php
│   │   ├── VehicleModel.php
│   │   ├── ServiceBookingModel.php
│   │   ├── ServiceBookingDetailsModel.php
│   │   └── ServiceTypesModel.php
│   └── views/                       # *.view.php templates
└── public/                          # web root
    ├── index.php
    ├── .htaccess
    └── assets/
        ├── css/
        ├── js/
        └── images/
```

---

## Routes

URLs follow `/{Controller}/{method}/{params}`. The default route is `Home/index`.

| URL | Method | Purpose |
|---|---|---|
| `/Home` | GET | Landing page |
| `/Home/userSignup` | POST | Create account and first vehicle |
| `/Home/userLogin` | POST | Log in |
| `/Home/logout` | GET | Destroy session |
| `/RegisteredUserHome` | GET | Customer dashboard |
| `/MyVehicles` | GET | List the customer's vehicles |
| `/MyVehicles/getVehicle/{id}` | GET | Vehicle details as JSON |
| `/MyVehicles/saveVehicle` | POST | Insert or update a vehicle (`mode` = `insertMode` / `updateMode`) |
| `/MyVehicles/deleteVehicle` | POST | Delete a vehicle |
| `/BookService` | GET | Mileage form and recommendations UI |
| `/BookService/getRecommendations` | POST | AI recommendations as JSON |
| `/ServiceHistory` | GET | Service history |

The dashboard, My Vehicles, and Book Service pages redirect to `/Home` when no user is logged in.

---

## Database

The database is named `elite_auto_care`. The tables and columns below are taken from the model definitions in `app/models/`.

| Table | Columns |
|---|---|
| `users` | `user_id`, `email`, `password`, `first_name`, `last_name`, `phone_number` |
| `vehicles` | `vehicle_id`, `user_id`, `make`, `model`, `plate_number`, `vehicle_make_year`, `last_serviced_mileage`, `vehicle_img_path`, `vehicle_status` |
| `service_booking` | `booking_id`, `user_id`, `vehicle_id`, `service_date`, `time_slot`, `service_status`, `total_cost` |
| `service_booking_details` | `detail_id`, `booking_id`, `service_type_id`, `service_cost` |
| `service_types` | `service_type_id`, `service_name`, `description`, `base_price`, `estimated_duration`, `is_available` |

Relationships: a user has many vehicles and many bookings; a booking belongs to one vehicle and has many booking-detail rows, each pointing to a service type.

---

## Getting Started

### Prerequisites

- PHP 7.4 or later with the `pdo_mysql` and `curl` extensions enabled
- MySQL 
- Apache with `mod_rewrite` enabled and `AllowOverride All` for the project folder
- A free [OpenRouter](https://openrouter.ai) API key (only needed for the AI recommendations)

A local stack such as XAMPP or WAMP covers all of the above.

### Installation

1. **Clone the repository** into your web server's document root, using the folder names the default config expects:

   ```bash
   cd /path/to/htdocs
   mkdir gitEliteAutoCare && cd gitEliteAutoCare
   git clone https://github.com/jabir0331/eliteAutoCareFinal.git
   ```

2. **Create the database.** Create a MySQL database named `elite_auto_care`, then create the five tables listed under [Database](#database).

3. **Check the configuration** in `app/core/config.php`. The defaults assume MySQL on `localhost` with user `root` and an empty password.

4. **Add your OpenRouter API key**. See [Configuration](#configuration).

5. **Start Apache and MySQL**, then open:

   ```
   http://localhost/gitEliteAutoCare/eliteAutoCareFinal/public
   ```

---

## Configuration

All settings live in `app/core/config.php`:

| Constant | Purpose | Default |
|---|---|---|
| `ROOT` | Base URL of the `public/` folder | `http://localhost/gitEliteAutoCare/eliteAutoCareFinal/public` |
| `CSS`, `IMAGES`, `JS`, `UPLOADS` | Asset base URLs | Derived from the same base path |
| `DBHOST`, `DBNAME`, `DBUSER`, `DBPASS` | Database connection | `localhost`, `elite_auto_care`, `root`, *(empty)* |

If you install the project under a different folder name, update the base URL in every URL constant above.

**OpenRouter API key.** The key is read in `BookService::getAIRecommendations()` in `app/controllers/BookService.php`. Set it to your own key before using the recommendations feature. Never commit a real key to a public repository; load it from an environment variable or an untracked config file instead.

---

## Project Status and Roadmap

Completed:
- MVC core, routing, and the generic model layer
- Landing page, signup (with first vehicle), login, logout
- Customer dashboard
- Vehicle management (add, edit, delete, image upload)
- AI-powered service recommendations

Planned or in progress:
- **Booking flow**: "Continue to Booking" and "Add to Service" on the Book Service page are placeholders. The `service_booking` tables are modelled, but bookings are not created yet.
- **Service History**: the page layout and status tabs are built, but they currently show sample data rather than database records.
- **Dashboard widgets**: "next service" and "next booking" indicators are scaffolded but not yet wired up.
- **Book Service page**: the last-mileage figure is currently fixed at 42,000 km instead of the vehicle's stored `last_serviced_mileage`.
- **Image uploads**: the upload handler needs a filesystem directory (for example `public/uploads/vehicles/`) defined for it. `UPLOADS` in the config is a URL, not a path.
- **Access control and hardening**: the Service History page does not check for a logged-in user yet, and `ServiceBookingModel` declares `$allowed_columns` instead of `$allowedColumns`, so its column whitelist is not applied.
- A SQL schema file, so the database can be created in one step
- An admin or garage-side interface for approving and completing bookings

---

## Team

| GitHub | Main contribution |
|---|---|
| [@jabir0331](https://github.com/jabir0331) | MVC core and models, landing page with signup/login, 404 handling, Book Service with AI recommendations |
| [@judeajanthan](https://github.com/judeajanthan) | Registered-user dashboard |
| [@Thagshan01](https://github.com/Thagshan01) | My Vehicles (create, edit, delete) |
| [@Abdulla-Zakey](https://github.com/Abdulla-Zakey) | Service History views |
