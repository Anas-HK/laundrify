# Laundrify - Docker Microservices Application

## Description
Laundrify is a comprehensive laundry service center management system built with Laravel and MySQL. It allows users to browse laundry services, place orders, track their laundry status, and communicate with service providers. Service providers can list their services, manage orders, and interact with customers. The platform includes features like order tracking, real-time notifications, and customer feedback.

## Architecture
![Architecture Diagram](architecture.png)

The application consists of two main services:
1. **Web Application (Laravel)**: Handles user requests, business logic, and UI
2. **Database (MySQL)**: Stores application data including user info, services, and orders

## Setup Instructions

### Prerequisites
- Docker installed on your system
- Git to clone this repository

### Step 1: Clone the Repository
```bash
git clone https://github.com/yourusername/laundrify.git
cd laundrify
```

### Step 2: Create Docker Network
```bash
docker network create laundrify-network
```

### Step 3: Build Docker Images
```bash
# Build Laravel app image
docker build -t laundrify-app .

# Build MySQL database image
docker build -t laundrify-db ./db
```

### Step 4: Run Database Container
```bash
docker run -d \
  --name laundrify-db-container \
  --network laundrify-network \
  -e MYSQL_DATABASE=laundrify \
  -e MYSQL_ALLOW_EMPTY_PASSWORD=yes \
  -e MYSQL_ROOT_PASSWORD= \
  -p 3306:3306 \
  laundrify-db
```

### Step 5: Run Laravel Application Container
```bash
docker run -d \
  --name laundrify-app \
  --network laundrify-network \
  -p 8000:80 \
  -e DB_HOST=laundrify-db-container \
  -e DB_DATABASE=laundrify \
  -e DB_USERNAME=root \
  -e DB_PASSWORD= \
  laundrify-app
```

### Step 6: Access the Application
Open your browser and navigate to [http://localhost:8000]

### Step 7: Run Health Monitor (Creative Enhancement)
```bash
# Run the health monitor script
./health_monitor.sh

# Or set up as a cron job
(crontab -l 2>/dev/null; echo "*/5 * * * * $(pwd)/health_monitor.sh >> $(pwd)/healthcheck.log 2>&1") | crontab -
```

## Container Management

### Check Container Status
```bash
docker ps -a
```

### View Container Logs
```bash
# View Laravel app logs
docker logs laundrify-app

# View MySQL logs
docker logs laundrify-db-container
```

### Access Container Shell
```bash
# Access Laravel app shell
docker exec -it laundrify-app /bin/bash

# Access MySQL shell
docker exec -it laundrify-db-container mysql -uroot -proot laundrify
```

### Stop Containers
```bash
docker stop laundrify-app laundrify-db-container
```

### Remove Containers
```bash
docker rm laundrify-app laundrify-db-container
```

## Docker Hub Deployment

### Tag Images for Docker Hub
```bash
# Tag images (replace yourusername with your Docker Hub username)
docker tag laundrify-app yourusername/laundrify-app:v1
docker tag laundrify-db yourusername/laundrify-db:v1
```

### Push Images to Docker Hub
```bash
# Login to Docker Hub
docker login

# Push images
docker push yourusername/laundrify-app:v1
docker push yourusername/laundrify-db:v1
```

## Creative Enhancement: Health Monitoring System

This project includes a custom health monitoring system that checks the status of both containers and automatically restarts them if they become unhealthy. This ensures high availability of the application.

The monitoring system:
- Checks database connectivity
- Verifies Laravel application responsiveness
- Logs health check results for troubleshooting
- Automatically restarts unhealthy containers

You can view the health check logs in `healthcheck.log` and monitor the status of containers with `docker ps`.

### Screenshots

![Home Page](screenshots/home.png)

![Services Page](screenshots/services.png)

![Order Tracking](screenshots/order_tracking.png)

## Docker Hub Images
- [Laundrify App Image](https://hub.docker.com/yourusername/laundrify-app)
- [Laundrify DB Image](https://hub.docker.com/yourusername/laundrify-db)