````md
# Symfony Commerce

> A modern, API-first e-commerce platform built with **Symfony 7**, **API Platform**, **React**, **PostgreSQL**, and **Docker**.

Symfony Commerce is an educational and production-oriented project inspired by **Sylius**, redesigned with modern architecture principles including:

- Domain-Driven Design (DDD)
- CQRS
- API First
- React Frontend
- Modular Monolith
- OWASP ASVS
- SOLID

The goal is **not** to clone Sylius, but to build a modern commerce platform using the best ideas from Sylius while leveraging current Symfony and React ecosystems.

---

# Tech Stack

## Backend

- PHP 8.4
- Symfony 7
- API Platform
- Doctrine ORM
- PostgreSQL
- Redis
- PHPUnit

## Frontend

- React
- TypeScript
- Vite
- React Query
- Tailwind CSS
- shadcn/ui

## Infrastructure

- Docker
- Docker Compose
- Nginx
- WSL2

---

# Project Structure

```
backend/
    src/
        Catalog/
        Customer/
        Cart/
        Checkout/
        Order/
        Payment/
        Shipment/
        Promotion/
        Tax/
        Channel/
        Security/
        Shared/

frontend/

docker/
```

---

# Current Architecture

Each business module follows the same structure.

```
Catalog/
    Product/

        Api/
        Application/
        Factory/
        Model/
        Repository/
```

Example:

```
Product
│
├── Api
│
├── Application
│   ├── Commands
│   └── Handlers
│
├── Factory
│
├── Model
│
└── Repository
```

Business logic is placed inside **Application** and **Factories**.

Controllers remain thin.

---

# Current Domain

## Catalog

- Product
- ProductVariant
- ProductOption
- ProductOptionValue

Next:

- Category
- ProductImage
- ProductAttribute
- ProductAttributeValue

---

# Planned Modules

## Catalog

- Product
- ProductVariant
- ProductOption
- ProductOptionValue
- Category
- ProductImage
- ProductAttribute
- ProductAttributeValue
- ProductAssociation
- ProductAssociationType
- ProductPrice
- Inventory

## Customer

- Customer
- CustomerGroup
- Address
- Wishlist
- WishlistItem

## Cart

- Cart
- CartItem
- CartAdjustment
- CartCoupon

## Order

- Order
- OrderItem
- OrderShipment
- OrderPayment
- OrderHistory

## Checkout

- Checkout
- CheckoutAddress
- CheckoutShipping
- CheckoutPayment

## Shipment

- Shipment
- ShipmentMethod
- ShipmentTracking

## Payment

- Payment
- PaymentMethod
- PaymentTransaction
- Refund

## Promotion

- Promotion
- PromotionCoupon
- PromotionRule
- PromotionAction

## Tax

- TaxCategory
- TaxRate

## Channel

- Channel
- Currency
- Locale
- ChannelPricing

---

# Installation

Clone repository

```bash
git clone https://github.com/your-name/symfony-commerce.git
```

Start Docker

```bash
docker compose up -d --build
```

Install backend dependencies

```bash
docker compose exec php composer install
```

Run migrations

```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```

Install frontend dependencies

```bash
docker compose exec frontend npm install
```

Run frontend

```bash
docker compose exec frontend npm run dev
```

---

# Development Principles

- PSR-12
- SOLID
- DDD
- CQRS
- API First
- Modular Monolith
- Feature Based Structure

---

# Security

Security follows:

- OWASP ASVS
- OWASP Top 10
- Symfony Security Best Practices

Future features:

- CSRF
- Rate Limiting
- JWT
- OAuth2
- API Tokens
- Audit Logs

---

# Roadmap

## Phase 1

- Product
- Product Variant
- Product Option
- Product Option Value

## Phase 2

- Categories
- Images
- Attributes
- Inventory

## Phase 3

- Cart
- Checkout
- Orders

## Phase 4

- Payments
- Shipment
- Promotions

## Phase 5

- Administration
- Dashboard
- Reporting
- Search
- Notifications

---

# License

MIT
````
