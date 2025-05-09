document.addEventListener('DOMContentLoaded', function () {

  // Reimbursement Status

  const reimbursementChartElement = document.getElementById('reimbursementChart');
  if (reimbursementChartElement) {
    const pie = reimbursementChartElement.getContext('2d');
    new Chart(pie, {
      type: 'pie', 
      data: {
        labels: ['Approved', 'Rejected', 'Pending', 'Claimed'],
        datasets: [{
          label: 'Reimbursement',
          data: [300, 50, 100, 100],
          backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            enabled: true
          }
        }
      }
    });
  }
  

  // Reimbursement Line Status

  const reimbursementlineChartElement = document.getElementById('reimbursementlineChart');
  if (reimbursementlineChartElement) {
    const line = reimbursementlineChartElement.getContext('2d');
    new Chart(line, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
          label: 'Reimbursement',
          data: [65, 59, 80, 81, 56, 55, 40],
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          fill: true,
          tension: 0.1
        }]
      },
      options: {
        responsive: true,
        scales: {
          x: {
            beginAtZero: true
          },
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }

  // Weekly Barchart

  const weeklyattendanceChartElement = document.getElementById('weeklyattendanceChart');
  if (weeklyattendanceChartElement) {
    const bar = weeklyattendanceChartElement.getContext('2d');
    new Chart(bar, {
      type: 'bar',
      data: {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        datasets: [
          {
            label: 'Present',
            data: [10, 10, 9, 10, 8, 10, 10], 
            backgroundColor: 'rgba(75, 192, 192, 0.6)', 
            borderWidth: 1
          },
          {
            label: 'Absent',
            data: [0, 0, 1, 0, 2, 0, 0], 
            backgroundColor: 'rgba(255, 99, 132, 0.6)', 
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
          x: {
            stacked: true 
          },
          y: {
            stacked: true 
          }
        }
      }
    });
  }

  // Attendance Rate
  
  const attendanceRateChartElement = document.getElementById('attendanceRateChartElement');
  if (attendanceRateChartElement) {
    const donut = attendanceRateChartElement.getContext('2d');
    new Chart(donut, {
      type: 'doughnut',
      data: {
        labels: ['Present', 'Absent', 'Late', 'On-Leave'],
        datasets: [{
          label: 'Attendance',
          data: [90, 4, 6, 5],
          backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            enabled: true
          }
        }
      }
    });
  }

  // Employee Profile Radar

  const employeeRadarChartElement = document.getElementById('employeeRadarChart');
  if (employeeRadarChartElement) {
    const radar = employeeRadarChartElement.getContext('2d');
    new Chart(radar, {
      type: 'radar',
      data: {
        labels: ['Communication', 'Technical Skills', 'Problem-Solving', 'Teamwork', 'Creativity', 'Leadership'],
        datasets: [{
          label: 'Employee Skills',
          data: [85, 90, 75, 80, 70, 95], 
          backgroundColor: 'rgba(75, 192, 192, 0.2)', 
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 2,
          pointBackgroundColor: 'rgba(75, 192, 192, 1)',
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            enabled: true,
          }
        },
        scales: {
          r: {  
            angleLines: {
              display: true,
            },
            suggestedMin: 0,  
            suggestedMax: 100, 
          }
        }
      }
    });
  }

  // Employee Profile Net Income

  const employeeLineCharttElement = document.getElementById('employeeLineChart');
  if (employeeLineCharttElement) {
    const line = employeeLineCharttElement.getContext('2d');
    new Chart(line, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
          {
            label: 'Payroll',
            data: [65, 59, 80, 81, 56, 55, 40], 
            borderColor: 'rgba(75, 192, 192, 1)', 
            tension: 0.1
          },
          {
            label: 'Claims',
            data: [12, 19, 3, 5, 2, 3, 7], 
            borderColor: 'rgba(0, 128, 0, 1)', 
            tension: 0.1
          },
          {
            label: 'Deductions',
            data: [5, 10, 15, 10, 20, 5, 7], 
            borderColor: 'rgba(255, 99, 132, 1)', 
            tension: 0.1
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          x: {
            beginAtZero: true
          },
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }
  

  // Employee Profile Attendance Rate

  const employeeattendanceRateChartElement = document.getElementById('employeeattendanceRateChartElement');
  if (employeeattendanceRateChartElement) {
    const donut = employeeattendanceRateChartElement.getContext('2d');
    new Chart(donut, {
      type: 'doughnut',
      data: {
        labels: ['Present', 'Absent', 'Late', 'On-Leave'],
        datasets: [{
          label: 'Attendance',
          data: [90, 4, 6, 5],
          backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            enabled: true
          }
        }
      }
    });
  }


    // Leave Status

    const leaveChartElement = document.getElementById('leaveChart');
    if (leaveChartElement) {
      const donut = leaveChartElement.getContext('2d');
      new Chart(donut, {
        type: 'doughnut',
        data: {
          labels: ['Approved', 'Rejected', 'Pending'],
          datasets: [{
            label: 'Reimbursement',
            data: [300, 50, 100],
            backgroundColor: [
              'rgba(54, 162, 235, 0.6)',
              'rgba(255, 99, 132, 0.6)',
              'rgba(255, 206, 86, 0.6)',
            ],
            borderColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(255, 99, 132, 1)',
              'rgba(255, 206, 86, 1)',
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            tooltip: {
              enabled: true
            }
          }
        }
      });
    }
  
    // Payroll Line Chart

    const payrollLineCharttElement = document.getElementById('payrollLineChart');
    if (payrollLineCharttElement) {
      const bar = payrollLineCharttElement.getContext('2d');
      new Chart(bar, {
        type: 'bar',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
          datasets: [{
            label: 'Payroll',
            data: [65, 59, 80, 81, 56, 55, 40],
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 1)',
            fill: true,
            tension: 0.1
          }]
        },
        options: {
          responsive: true,
          scales: {
            x: {
              beginAtZero: true
            },
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }

})