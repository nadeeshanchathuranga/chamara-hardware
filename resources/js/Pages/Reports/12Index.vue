<template>
  <div class="chart-container">
    <Bar :data="chartData" :options="chartOptions" />
  </div>
</template>

<script>
import { defineComponent } from 'vue';
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js';

// Register necessary chart components
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

export default defineComponent({
  name: 'ChartPage',
  components: {
    Bar
  },
  data() {
    return {
      // Chart data
      chartData: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [
          {
            label: 'Sales',
            backgroundColor: '#42A5F5',
            data: [65, 59, 80, 81, 56]
          }
        ]
      },
      // Chart options
      chartOptions: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Monthly Sales Data'
          },
          tooltip: {
            mode: 'index',
            intersect: false
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    };
  }
});
</script>


<style scoped>
.chart-container {
  width: 100%;
  height: 300px;
}
</style>
