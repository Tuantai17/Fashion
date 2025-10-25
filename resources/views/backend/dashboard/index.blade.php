<x-layout-admin>
  <div class="content-wrapper">

    <div class="bg-white rounded-lg p-4">
      <h2 class="text-xl font-bold text-[rgb(246,81,119)] mb-4">DASHBOARD</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Biểu đồ Doanh thu -->
        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
          <h3 class="text-lg font-semibold text-[rgb(246,81,119)] mb-2">Doanh thu hàng tháng</h3>
          <canvas id="revenueChart"></canvas>
        </div>

        <!-- Biểu đồ Người dùng -->
        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
          <h3 class="text-lg font-semibold text-[rgb(246,81,119)] mb-2">Tăng trưởng người dùng</h3>
          <canvas id="userChart"></canvas>
        </div>

      </div>
    </div>

  </div>

  <!-- Biểu đồ script -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
      type: 'bar',
      data: {
        labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
        datasets: [{
          label: 'Doanh thu (triệu đồng)',
          data: [120, 150, 100, 180, 130],
          backgroundColor: 'rgba(246,81,119, 0.6)',
          borderColor: 'rgb(246,81,119)',
          borderWidth: 1,
          borderRadius: 10
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    const userCtx = document.getElementById('userChart').getContext('2d');
    new Chart(userCtx, {
      type: 'line',
      data: {
        labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
        datasets: [{
          label: 'Người dùng mới',
          data: [50, 70, 40, 90, 60],
          backgroundColor: 'rgba(246,81,119, 0.2)',
          borderColor: 'rgb(246,81,119)',
          tension: 0.4,
          fill: true,
          pointBackgroundColor: 'rgb(246,81,119)'
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</x-layout-admin>
