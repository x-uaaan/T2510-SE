<template>
  <Line :data="chartData" :options="chartOptions" />
</template>

<script setup>
import { Line } from 'vue-chartjs'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

const props = defineProps({
  chartData: {
    type: Object,
    required: true
  }
})

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'top',
       labels: {
        color: '#d1d5db', // text-gray-300
        font: {
          size: 14,
        }
      }
    }
  },
  scales: {
    y: {
      ticks: { 
        color: '#9ca3af', // text-gray-400
      },
      grid: {
        color: '#374151', // border-gray-700
      }
    },
    x: {
      ticks: { 
        color: '#9ca3af', // text-gray-400
      },
       grid: {
        display: false,
      }
    }
  }
}
</script> 