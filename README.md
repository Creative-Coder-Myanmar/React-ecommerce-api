# Installation

```bash
    git clone https://github.com/Creative-Coder-Myanmar/React-ecommerce-api.git
    cd React-ecommerce-api
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan storage:link
    touch database/database.sqlite
    php artisan migrate:fresh --seed
    php artisan serve
```

## API Documentation

## Overview

This API provides endpoints for user authentication, managing categories, products, and orders in an e-commerce application built with Laravel.

## Base URL

http://localhost:8000/api

## Authentication

All requests (except user registration and login and get products and single product and get categories) require an authentication token. Include the token in the `Authorization` header as follows:

**Authorization: Bearer {token}**

## Endpoints

### 1. User Authentication

#### Create User

-   **Endpoint:** `POST /api/users`
-   **Description:** Register a new user.
-   **Request Body:**
    ```json
    {
        "name": "string",
        "email": "string",
        "password": "string|min:6|max:30",
        "phone": "integer|min:9",
        "address": "string"
    }
    ```
-   **Response:**
    -   **201 Created**
        ```json
        {
            "message": "User created",
            "token": "string"
        }
        ```
-   **Response:**
    -   **422 Unprocessable Content**
        ```json
        {
            "message": "Unprocessable dat.",
            "errors": {
                "name": "Validation error message",
                "email": "Validation error message",
                "password": "Validation error message",
                "phone": "Validation error message",
                "address": "Validation error message"
            }
        }
        ```

#### Login User

-   **Endpoint:** `POST /api/login`
-   **Description:** Authenticate a user and return a token.
-   **Request Body:**

    ```json
    {
        "email": "string",
        "password": "string"
    }
    ```

-   **Response:**
    -   **200 OK**
        ```json
        {
            "message": "login success",
            "token": "string"
        }
        ```
-   **Response:**
    -   **422 Unprocessable Content**
        ```json
        {
            "errors": {
                "email": "Validation error message"
            }
        }
        ```

#### Get Authenticated User

-   **Endpoint:** `GET /api/user`
-   **Description:** Retrieve the authenticated user's details.
-   **Response:**
    -   **200 OK**
        ```json
        {
            "id": "integer",
            "name": "string",
            "email": "string",
            "email_verified_at": "DateTime",
            "profile": "string|null",
            "role_id": "number",
            "phone": "string",
            "address": "string",
            "created_at": "DateTime",
            "updated_at": "DateTime"
        }
        ```

### 2. Categories

#### Get Categories

-   **Endpoint:** `GET /api/categories`
-   **Description:** Retrieve a list of all categories.
-   **Response:**
    -   **200 OK**
        ```json
        [
            {
                "id": "integer",
                "name": "string"
            }
        ]
        ```

#### Create Category (Admin Only)

-   **Endpoint:** `POST /api/categories`
-   **Description:** Create a new category.
-   **Request Body:**
    ```json
    {
        "name": "string"
    }
    ```
-   **Response:**
    -   **201 Created**
        ```json
        {
            "message": "category created.",
            "category": {
                "id": "integer",
                "name": "string"
            }
        }
        ```
-   **Response:**
    -   **422 Unprocessable Content**
        ```json
        {
            "message": "Unprocessable dat.",
            "errors": {
                "name": "Validation error message"
            }
        }
        ```

#### Update Category (Admin Only)

-   **Endpoint:** `PUT /api/categories/{category}`
-   **Description:** Update an existing category.
-   **Request Body:**
    ```json
    {
        "name": "string"
    }
    ```
-   **Response:**
    -   **200 OK**
        ```json
        {
            "message": "category updated.",
            "category": {
                "id": "integer",
                "name": "string"
            }
        }
        ```
-   **Response:**
    -   **422 Unprocessable Content**
        ```json
        {
            "message": "Unprocessable dat.",
            "errors": {
                "name": "Validation error message"
            }
        }
        ```

#### Delete Category (Admin Only)

-   **Endpoint:** `DELETE /api/categories/{category}`
-   **Description:** Delete a category.
-   **Response:**

    -   **200 OK**
        ```json
        {
            "message": "delete successful."
        }
        ```

    ```

    ```

### 3. Products

#### Get Products

-   **Endpoint:** `GET /api/products`
-   **Description:** Retrieve a list of all products.
-   **Response:**
    -   **200 OK**
        ```json
        [
            {
                "id": "integer",
                "name": "string",
                "price": "number",
                "description": "string",
                "category": {
                    "id": "interger",
                    "name": "string"
                },
                "images": [
                    {
                        "id": "interger",
                        "product_id": "integer",
                        "url": "string"
                    }
                ]
            }
        ]
        ```

#### Get Product

-   **Endpoint:** `GET /api/products/{product}`
-   **Description:** Retrieve a single product by ID.
-   **Response:**
    -   **200 OK**
        ```json
        {
            "id": "integer",
            "name": "string",
            "price": "number",
            "description": "string",
            "category": {
                "id": "interger",
                "name": "string"
            },
            "images": [
                {
                    "id": "interger",
                    "product_id": "integer",
                    "url": "string"
                }
            ]
        }
        ```

#### Create Product (Admin Only)

-   **Endpoint:** `POST /api/products`
-   **Description:** Create a new product.
-   **Request Body:**
    ```json
    {
        "name": "string",
        "price": "number",
        "category_id": "integer",
        "description": "string"
    }
    ```
-   **Response:**
    -   **201 Created**
        ```json
        {
            "message": "product created successful.",
            "product": {
                "name": "string",
                "price": "integer",
                "description": "string",
                "category_id": "integer",
                "id": "integer"
            }
        }
        ```
-   **Response:**
    -   **422 Unprocessable Content**
        ```json
        {
            "message": "Unprocessable dat.",
            "errors": {
                "name": "Validation error message",
                "price": "Validation error message",
                "category_id": "Validation error message",
                "description": "Validation error message"
            }
        }
        ```

#### Update Product (Admin Only)

-   **Endpoint:** `PUT /api/products/{product}`
-   **Description:** Update an existing product.
-   **Request Body:**
    ```json
    {
        "name": "string",
        "price": "number",
        "description": "string",
        "category_id": "1"
    }
    ```
-   **Response:**
    -   **200 OK**
        ```json
        {
            "message": "product update successful.",
            "product": {
                "name": "string",
                "price": "integer",
                "description": "string",
                "category_id": "integer",
                "id": "integer"
            }
        }
        ```
-   **Response:**
    -   **422 Unprocessable Content**
        ```json
        {
            "message": "Unprocessable dat.",
            "errors": {
                "name": "Validation error message",
                "price": "Validation error message",
                "category_id": "Validation error message",
                "description": "Validation error message"
            }
        }
        ```

#### Delete Product (Admin Only)

-   **Endpoint:** `DELETE /api/products/{product}`
-   **Description:** Delete a product.
-   **Response:**
    -   **200 OK**
        ```json
        {
            "message": "product delete successful"
        }
        ```

#### Update Product Image (Admin Only)

-   **Endpoint:** `POST /api/products/{product}/update-image`
-   **Description:** Update the image of a product.
-   **Request Body:** Form data with file input. Field - images
-   **Response:**
    -   **200 OK**
        ```json
        {
            " message": " product images updated success."
        }
        ```

### 4. Orders

#### Get Orders

-   **Endpoint:** `GET /api/orders`
-   **Description:** Retrieve a list of all orders.
-   **Response:**
    -   **200 OK**
        ```json
        [
            {
                "id": "integer",
                "user_id": "integer",
                "total": "number",
                "status": "string"
            }
        ]
        ```

#### Get Order

-   **Endpoint:** `GET /api/orders/{order}`
-   **Description:** Retrieve a single order by ID.
-   **Response:**
    -   **200 OK**
        ```json
        {
            "id": "integer",
            "status": "confirmed|pending",
            "total_amount": "integer",
            "address": "string",
            "screen_shot": "string",
            "notes": "string",
            "user_id": "integer",
            "created_at": "DateTime",
            "updated_at": "DateTime",
            "products": [
                {
                    "id": "integer",
                    "name": "string",
                    "description": "string",
                    "price": "integer",
                    "category_id": "integer",
                    "created_at": "DateTime",
                    "updated_at": "DateTime",
                    "pivot": {
                        "order_id": "integer",
                        "product_id": "integer"
                    }
                }
            ]
        }
        ```

#### Create Order

-   **Endpoint:** `POST /api/orders`
-   **Description:** Create a new order.
-   **Request Body:**
    ```json
    {
        "total_amount": "number",
        "order_products": [
            {
                "product_id": "integer",
                "quantity": "integer"
            }
        ],
        "shipping_address": "string|nullable",
        "notes": "string|nullable",
        "screen_shot": "string|nullable"
    }
    ```
-   **Response:**

    -   **201 Created**
        ```json
        {
            "message": "order create successful.",
            "order": "object"
        }
        ```

-   **Response:**
    -   **422 Unprocessable Content**
        ```json
        {
            "message": "Unprocessable dat.",
            "errors": {
                "total_amount": "Validation error message",
                "order_products": "Validation error message",
                "shipping_address": "Validation error message",
                "notes": "Validation error message",
                "screen_shot": "Validation error message"
            }
        }
        ```

#### Update Order status (Admin Only)

-   **Endpoint:** `PUT /api/orders/{order}`
-   **Description:** Update an existing order.
-   **Request Body:**
    ```json
    {
        "status": "confirmed"
    }
    ```
-   **Response:**
    -   **200 OK**
        ```json
        {
            "message": "order update successful.",
            "product": "object"
        }
        ```

#### Delete Order (Admin Only)

-   **Endpoint:** `DELETE /api/orders/{order}`
-   **Description:** Delete an order.
-   **Response:**
    -   **200 OK**
        ```json
        {
            "message": "order delete successful"
        }
        ```

## Error Responses

Common error responses include:

-   **400 Bad Request**
    ```json
    {
        "message": "Invalid request."
    }
    ```
-   **401 Unauthorized**
    ```json
    {
        "message": "Unauthorized."
    }
    ```
-   **404 Not Found**
    ```json
    {
        "message": "Resource not found."
    }
    ```
-   **500 Internal Server Error**
    ```json
    {
        "message": "An error occurred."
    }
    ```

## Conclusion

This documentation outlines the basic usage and response structures for the API endpoints. Ensure to handle authentication and authorization properly in your application.

### Admin Account Credentials

-   **Email:** `admin@gmail.com`
-   **Password:** `adminpassword`
