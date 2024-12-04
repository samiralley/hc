<div id="monitoringStats" class="monitoring-stats">
    <h2>Real-Time Monitoring</h2>
    <ul>
        <li>Total Requests: <span id="totalRequests"></span></li>
        <li>Total Tokens Used: <span id="totalTokens"></span></li>
        <li>Cache Hits: <span id="cacheHits"></span></li>
        <li>Cache Misses: <span id="cacheMisses"></span></li>
    </ul>
</div>

<script>
fetch('/backend/monitoring_api.php')
    .then(response => response.json())
    .then(stats => {
        document.getElementById('totalRequests').textContent = stats.total_requests;
        document.getElementById('totalTokens').textContent = stats.total_tokens;
        document.getElementById('cacheHits').textContent = stats.cache_hits;
        document.getElementById('cacheMisses').textContent = stats.cache_misses;
    })
    .catch(err => console.error('Error fetching monitoring stats:', err));
</script>
