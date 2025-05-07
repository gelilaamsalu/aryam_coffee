<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aryam Coffee Admin Dashboard</title>
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<style>
        #stats {
            display: flex;
            justify-content: space-around;
            margin-left: 270px;
           
        }
        .stat {
            background-color: white;
            padding: 5px 50px;
            border-radius: 5px;
            text-align: center;
            color: #e4d2ab;
        }
        .stat h2{
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            
            color: #353028;
        }
        .orderChart {
            width: 70%;
            max-width: 340px;
            height: 80px; /* Fixed height */
            border-radius: 5px;
            background-color: white;
            margin: 25px auto; /* Centering the chart */
            max-height: 250px;
            margin-left: 270px ;
            margin-right: -240px ;
        }
        #orderChart {
          borderWidth:1px;
        }
        #head {
            padding-bottom: 2.6%;
        }
        #navbar1 {
            margin-top: 18px;
        }
        #navbar i {
            letter-spacing: 10px;
            color: #e4d2ab;
        }
        .plugin{
            display:flex;
            
        }
        
        
    </style>

<section id="head">
    <div>
        <p id="contactss">Aryam Coffee Admin Dashboard</p>
        <ul id="navbar1">
            <li><a class="active" href="./home.php">Logout</a></li>
        </ul>
    </div>
</section>

<section id="header">
    <img src="../sf/ph1.png" id="logo" alt="">
    <div>
        <ul id="navbar">
            <li><a class="active" href="#"><i class="fas fa-home"></i> HOME</a></li>
            <li><a href="./feed back/feed back.php"><i class="fas fa-comments"></i> FEEDBACK</a></li>
            <li><a href="./testimonial/testimonial.php"><i class="fas fa-quote-left"></i> TESTIMONIAL</a></li>
            <li><a href="./roast/roast.php"><i class="fas fa-coffee"></i> ROAST</a></li>
            <li><a href="./contact us/contact us.php"><i class="fas fa-envelope"></i> CONTACT US</a></li>
            <li><a href="./menu/menu.php"><i class="fas fa-utensils"></i> MENU</a></li>
            <li><a href="./order/order.php"><i class="fas fa-shopping-cart"></i> ORDER</a></li>
            <li><a href="./reservation/reservation.php"><i class="fas fa-calendar-alt"></i> RESERVATION</a></li>
            <li><a href="./manage users/manage users.php"><i class="fas fa-users-cog"></i> MANAGE USERS</a></li>
        </ul>
    </div>
</section><br><br>

<div id="stats">
    <div class="stat">
        <i class="fas fa-box fa-2x"></i>
        <h3>Total Products</h3>
        <h2 id="totalProducts">0</h2>
    </div>
    <div class="stat">
        <i class="fas fa-shopping-cart fa-2x"></i>
        <h3>Total Orders</h3>
        <h2 id="totalOrders">0</h2>
    </div>
    <div class="stat">
        <i class="fas fa-calendar-check fa-2x"></i>
        <h3>Total Reservations</h3>
        <h2 id="totalReservations">0</h2>
    </div>
    <div class="stat">
        <i class="fas fa-store fa-2x"></i>
        <h3>Total Branches</h3>
        <h2 id="totalBranches">0</h2>
    </div>
</div>

<div class="plugin">
    <canvas id="orderChart" class="orderChart"></canvas>
    <canvas id="productChart" class="orderChart"></canvas>
    <canvas id="reservationChart" class="orderChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-3d"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('getData.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalProducts').textContent = data.totalProducts;
                document.getElementById('totalOrders').textContent = data.totalOrders;
                document.getElementById('totalReservations').textContent = data.totalReservations;
                document.getElementById('totalBranches').textContent = data.totalBranches;

                const ctxOrders = document.getElementById('orderChart').getContext('2d');
                const ctxProducts = document.getElementById('productChart').getContext('2d');
                const ctxReservations = document.getElementById('reservationChart').getContext('2d');

                // Create gradient for the charts
                let orderGradient = ctxOrders.createLinearGradient(0, 0, 0, 400);
                orderGradient.addColorStop(0, 'rgba(75, 192, 192, 0.5)');
                orderGradient.addColorStop(1, 'rgba(75, 192, 192, 1)');

                let productGradient = ctxProducts.createLinearGradient(0, 0, 0, 400);
                productGradient.addColorStop(0, 'rgba(255, 206, 86, 0.5)');
                productGradient.addColorStop(1, 'rgba(255, 206, 86, 1)');

                let reservationGradient = ctxReservations.createLinearGradient(0, 0, 0, 400);
                reservationGradient.addColorStop(0, 'rgba(153, 102, 255, 0.5)');
                reservationGradient.addColorStop(1, 'rgba(153, 102, 255, 1)');

                // Bar Chart (Orders) with 3D effect
                const orderChart = new Chart(ctxOrders, {
                    type: 'bar',
                    data: {
                        labels: data.chartData.map(item => item.order_date),
                        datasets: [{
                            label: 'Orders',
                            data: data.chartData.map(item => item.order_count),
                            backgroundColor: orderGradient,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            'chartjs-plugin-3d': {
                                enabled: true,
                                perspective: 1000, // Perspective angle for 3D effect
                                shadowsEnabled: true, // Shadows for 3D bars
                                shadowsIntensity: 0.5,
                                shadowsColor: '#aaa',
                            },
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Pie Chart (Products) with 3D effect
                const productChart = new Chart(ctxProducts, {
                    type: 'pie',
                    data: {
                        labels: ['Total Products'],
                        datasets: [{
                            label: 'Total Products',
                            data: [data.totalProducts],
                            backgroundColor: productGradient,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            'chartjs-plugin-3d': {
                                enabled: true,
                                perspective: 1000,
                                shadowsEnabled: true, // Add shadows to enhance 3D effect
                                shadowsIntensity: 0.5,
                                shadowsColor: '#aaa',
                            },
                            legend: {
                                display: true
                            }
                        }
                    }
                });

                // Doughnut Chart (Reservations) with 3D effect
                const reservationChart = new Chart(ctxReservations, {
                    type: 'doughnut',
                    data: {
                        labels: ['Total Reservations'],
                        datasets: [{
                            label: 'Total Reservations',
                            data: [data.totalReservations],
                            backgroundColor: reservationGradient,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            'chartjs-plugin-3d': {
                                enabled: true,
                                perspective: 1000,
                                shadowsEnabled: true, // Add shadows to enhance 3D effect
                                shadowsIntensity: 0.5,
                                shadowsColor: '#aaa',
                            },
                            legend: {
                                display: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error)); // Error handling
    });
</script>




</body>
</html>
