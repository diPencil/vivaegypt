# 🌍 Viva Egypt Travel

**Viva Egypt Travel** is a comprehensive travel management and booking platform built with Laravel 10. It supports tours, flights, SPA services, transfers, and Nile cruises with a highly flexible modular architecture and a multi-theme CMS.

## 🚀 Key Features
- **Modular System**: Built using `nwidart/laravel-modules` for scalability.
- **Multi-Theme Support**: Dynamic theme switching (7 themes) via the admin dashboard.
- **Service Bookings**: Specialized modules for Tours, SPA, Flights, and more.
- **Localization**: Full RTL support and multi-language capabilities.
- **Payment Integration**: Multiple payment gateways support (Stripe, PayPal, Mollie, etc.).

## 📚 Documentation
For detailed technical documentation, architecture overview, and setup instructions, please refer to:
👉 **[PROJECT.md (Arabic Guide)](./PROJECT.md)**

---

## 🛠️ Installation

```bash
# Clone the repository
git clone <repo-url>

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start the application
php artisan serve
npm run dev
```

## 🔒 License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---
> Developed for **Viva Egypt Travel Team**.
