### Detailed Interface Documentation: Donation Website Application

#### Project Overview

This project is a **Laravel 11** application that allows users to donate to various causes. It features a modern interface for listing, creating, and donating to causes. The project is fully **Dockerized** for easy deployment and development, with a robust backend powered by Laravel's latest features.

##### Database Structure

This project consists of three primary models: User, Donation, and UserDonation. These models represent the users of the application, donation campaigns, and the transactions (donations) made by users, respectively.

```mermaid
erDiagram
    USER {
        int id
        string name
        string email
        string password
        datetime email_verified_at
    }
    
    DONATION {
        int id
        int user_id
        decimal target_amount
        string status
        string title
        string description
        datetime due_date
        string details
    }

    USERDONATION {
        int id
        int user_id
        int donation_id
        decimal amount
    }

    USER ||--o{ DONATION : "has many"
    DONATION ||--o{ USERDONATION : "has many"
    USER ||--o{ USERDONATION : "has many"
    USERDONATION }--|| USER : "belongs to"
    USERDONATION }--|| DONATION : "belongs to"
```

By following this schema, the project tracks users, the donations they initiate, and the contributions they make to various campaigns.

* * * * *

### 1\. **Installation and Setup**

#### Prerequisites

-   **Docker** must be installed on your machine. If you don't have Docker installed, use the following command to install it:

#### Installing Project Dependencies

1.  **Clone the repository**:

    ```bash
    git https://github.com/andojoks/crowdfunding_app.git
    cd donation-website
    ```

2.  **Build and start Docker containers**:

  ```bash
    docker compose up -d
  ```

    This will set up the application in Docker, pulling all required services, including the database, web server, and PHP container.

3.  **Generate application key** (necessary for application encryption):

    ```bash
    docker compose exec app php artisan key:generate`
    ```
       
4.  **Run database migrations**:

    ```bash
    docker compose exec app php artisan migrate`
    ```

5.  **Seed the database** (optional, for testing or initial data):

    ```bash
    docker compose exec app php artisan db:seed
    ```

* * * * *

### 2\. **Application Interfaces**

#### **Home Page (`/`)**

-   **Purpose**: Display an overview of the most popular causes based on donation activity.
-   **Functionality**:
    -   Show highlighted causes with the most frequent donations.
    -   Allow users to browse through more causes.
-   **Access**: Public.
-   **Controller**: `HomeController@index`.

#### **Causes Page (`/causes`)**

-   **Purpose**: List all open causes available for donation.
-   **Functionality**:
    -   Show a list of causes where users can make donations.
    -   Causes are presented with short descriptions and links to full details.
-   **Access**: Public.
-   **Controller**: `DonationController@index`.

#### **Cause Details Page (`/causes/{id}`)**

-   **Purpose**: Display detailed information about a specific cause and allow users to make donations.
-   **Functionality**:
    -   Show detailed information about the selected cause.
    -   Allow authenticated users to make donations directly from this page.
-   **Access**: Public for viewing; only authenticated users can make donations.
-   **Controller**: `CauseController@show`, `DonationController@store`.

#### **My Causes Page (`/my-causes`)**

-   **Purpose**: Allows authenticated users to manage their own causes.
-   **Functionality**:
    -   Users can create new causes and update existing ones.
    -   Only non-completed causes can be edited.
-   **Access**: Restricted to authenticated users.
-   **Controller**: `CauseController@myCauses`.

#### **Cause Form (`/causes/create` or `/causes/{id}/edit`)**

-   **Purpose**: Create a new cause or edit an existing cause.
-   **Functionality**:
    -   Users can fill out forms to create or update causes.
    -   Cause updates are restricted to non-completed causes.
-   **Access**: Restricted to authenticated users.
-   **Controller**: `CauseController@create`, `CauseController@update`.

#### **Donation Form (`/causes/{id}`)**

-   **Purpose**: Allow authenticated users to make donations to causes.
-   **Functionality**:
    -   Donation form appears on the cause details page for authenticated users.
    -   Users can input the donation amount and payment details.
-   **Access**: Restricted to authenticated users.
-   **Controller**: `DonationController@store`.

* * * * *

### 3\. **Testing**

This project uses **Pest** for feature and unit testing.

#### Running Tests

To run the Pest tests, use the following command within the PHP container:

```bash
docker compose exec app ./vendor/bin/pest
```

These tests cover various functionalities such as:

-   **Unauthenticated access**: Ensure non-authenticated users cannot access donation and cause management features.
-   **Cause creation and editing**: Tests for authenticated users to create and edit causes.
-   **Donation process**: Verifies the donation process works correctly for authenticated users.
-   **Popular causes**: Tests to ensure the most popular causes are highlighted on the home page.

* * * * *

### 4\. **Registration and Authentication**

To access full features (e.g., creating causes, making donations), users must register and log in.

1.  **Registration**:

    -   Visit `http://localhost/register`.
    -   Complete the registration form to create an account.
2.  **Authentication**:

    -   After registration, users can log in via `http://localhost/login`.

    Once logged in, users can:

    -   Manage their own causes on the **My Causes** page.
    -   Create or update causes (non-completed).
    -   Make donations to any listed cause.

* * * * *

### 5\. **Exploring the Application**

Once registered and logged in, users can browse through the website and experience all its features:

-   **Popular Causes**: On the home page, users can view the most popular causes.
-   **Donate**: Users can navigate to any cause and make a donation.
-   **My Causes**: Authenticated users can create and manage their own causes.

Feel free to browse through the causes and **donate to a cause** that resonates with you!

* * * * *

### Conclusion

This professional-grade Laravel 11 application, packaged in Docker for easy deployment, provides a seamless experience for donating to causes. It integrates powerful features like authenticated user access, real-time cause updates, and secure donation processing.

If you encounter any issues during setup or deployment, ensure that all Docker services are running properly and that the database is migrated and seeded. Feel free to contribute, donate, and help causes flourish!