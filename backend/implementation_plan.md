# Updated Plan: PulseTrade Standalone React SPA + Laravel API

This plan incorporates all your specific requirements for converting **PulseTrade** into a decoupled **React SPA** with a **Laravel REST API** backend.

> [!IMPORTANT]
> **No code will be executed** until you review and approve this implementation plan.

---

## 🏗️ Architecture & Folder Structure

```
PulseTrade/
├── app/                  # Backend: Laravel 11 Controllers, Models, API Routes
├── config/               # Backend Config (CORS, Auth, Database)
├── database/             # Migrations & Seeders
├── routes/
│   ├── api.php           # REST API endpoints for React Frontend
│   └── web.php           # Base route / storage route handling
├── public/               # Backend public assets & uploaded product images
└── frontend/             # [NEW] Standalone React SPA Application
    ├── src/
    │   ├── assets/       # Static images, logos
    │   ├── components/   # Reusable components (Navbar, Footer, ProductCard, Slider, Card, etc.)
    │   ├── context/      # React Contexts (AuthContext, CartContext, ThemeContext)
    │   ├── layouts/      # MainLayout, AdminLayout, AuthLayout
    │   ├── pages/        # Storefront pages + Admin pages
    │   ├── services/     # Axios API service instances with dynamic base URLs
    │   ├── utils/        # Image URL helpers & formatters
    │   ├── App.jsx
    │   └── main.jsx
    ├── .env              # VITE_API_BASE_URL configuration
    ├── package.json
    ├── tailwind.config.js
    └── vite.config.js
```

---

## ✨ Key Requirements & Features

### 1. Separate Frontend & Backend Folders
- Standalone Vite React app located in `frontend/` directory.
- Backend API endpoints created under `routes/api.php` with CORS enabled (`config/cors.php`).

### 2. Dynamic URLs for InfinityFree / Shared Hosting
- API service helper will automatically build dynamic endpoint URLs using environment variables:
  ```js
  export const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || window.location.origin + '/api';
  export const STORAGE_BASE_URL = import.meta.env.VITE_STORAGE_BASE_URL || window.location.origin + '/storage';
  ```
- Image paths will use a smart helper `getImageUrl(path)` that gracefully falls back to default product mockups if no custom image is uploaded.

### 3. Both Customer Storefront & Admin Panel in React
- **Customer Storefront:**
  - Home Page with Hero Banner & Enhanced Product Slider.
  - Shop Page with category filter, price range slider, dynamic search, sorting.
  - Product Detail Page with image gallery slider, stock badges, reviews.
  - Interactive Slide-over Cart Drawer & Full Cart Page.
  - Checkout Page with Order Summary & address inputs.
  - User Dashboard (Profile info & Order history).
- **Admin Panel:**
  - Modern Dashboard with metrics (Sales, Orders, Low Stock).
  - Product CRUD (Data table, add/edit modal, image upload preview, delete confirmation).
  - Category CRUD.
  - Order Management (Status updates).

### 4. Functional Dark & Light Mode Toggle
- `ThemeContext` providing `theme` state (`dark` | `light`) persisted in `localStorage`.
- Toggles the `dark` class on `document.documentElement` for seamless Tailwind `dark:` styling.
- Sun/Moon icon toggle button integrated into the top Navbar across Customer and Admin views.

### 5. Card-Based Modern Login & Register Pages
- Centered card layout with elegant glassmorphism/shadow effects, brand navy gradient background, floating input icons, validation messages, and smooth transition toggles between Login and Register.

### 6. Enhanced React Product Slider
- Integrating **Swiper React** (or custom responsive touch slider) for featured product carousels, trending items, and product detail image galleries.

---

## 🛠️ Proposed Step-by-Step Execution Plan

### Step 1: Backend API Setup (Laravel)
- [MODIFY] [routes/api.php](file:///e:/xampp/htdocs/idb-project/PulseTrade/routes/api.php): Add REST API routes for auth, products, categories, cart, checkout, orders, reviews, and admin dashboard stats.
- [NEW] Create API Controllers in `app/Http/Controllers/Api/` (ProductController, CategoryController, AuthController, OrderController, AdminController).
- [MODIFY] [config/cors.php](file:///e:/xampp/htdocs/idb-project/PulseTrade/config/cors.php): Enable CORS for local dev (`http://localhost:5173`) and dynamic origins.

### Step 2: Initialize Frontend SPA
- [NEW] Create `frontend` directory using Vite + React.
- [NEW] Configure Tailwind CSS, PostCSS, and Lucide React / Swiper dependencies.
- [NEW] Setup dynamic API service (`src/services/api.js`) and image URL resolver (`src/utils/image.js`).

### Step 3: Core Contexts & Layouts
- [NEW] Create `ThemeContext.jsx` (Dark/Light mode).
- [NEW] Create `AuthContext.jsx` (Login, Register, Logout, User state).
- [NEW] Create `CartContext.jsx` (Add, remove, update quantities, total calculation, persistent cart).
- [NEW] Build `Navbar.jsx` with Theme Toggle, Search, Cart Drawer count, and User dropdown.
- [NEW] Build `Footer.jsx`, `MainLayout.jsx`, `AdminLayout.jsx`, `AuthLayout.jsx`.

### Step 4: Page Implementations
- [NEW] Modern Card-Based `LoginPage.jsx` & `RegisterPage.jsx`.
- [NEW] `HomePage.jsx` featuring Swiper Product Slider & Category Grid.
- [NEW] `ShopPage.jsx` & `ProductDetailPage.jsx`.
- [NEW] `CartPage.jsx` & `CheckoutPage.jsx`.
- [NEW] `UserProfilePage.jsx`.
- [NEW] `AdminDashboardPage.jsx`, `AdminProductsPage.jsx`, `AdminCategoriesPage.jsx`, `AdminOrdersPage.jsx`.

---

## 🧪 Verification Plan

### Automated / Command Verification
- Verify backend API routes respond correctly (`php artisan route:list --path=api`).
- Run Vite dev server in `frontend` and ensure clean build (`npm run build`).

### Manual & Visual Verification
- Test Dark/Light mode toggle across store and admin views.
- Test Login and Registration card UI.
- Verify product slider controls, touch drag, and responsive breakpoints.
- Test product images load seamlessly from storage and fallbacks.
- Test full order placement flow and admin order status updates.
