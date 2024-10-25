<div class="widget-body">
    <h3 class="widget-title" v-text="widget.configuration.title"></h3>

    <div v-if="!loading">
        <p>Current server time: <span v-if="fullWidgetData" v-text="fullWidgetData.data.current_time"></span></p>
    </div>
    <p v-else>Loading...</p>
</div>
