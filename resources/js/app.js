// resources/js/app.js

import './bootstrap';
import Alpine from 'alpinejs';

import Chart from 'chart.js/auto'; // Chart.jsをインポート

// グローバルスコープにChartを公開（Bladeからアクセスできるようにするため）
window.Chart = Chart;

window.Alpine = Alpine;
Alpine.start();
