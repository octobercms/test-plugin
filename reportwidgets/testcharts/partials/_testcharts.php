<div class="report-widget">
    <h3>
        <?= e($this->property('title')) ?>
    </h3>

    <?php if (!isset($error)): ?>

        <h4>
            Pie Chart
        </h4>
        <div
            class="control-chart centered wrap-legend"
            data-control="chart-pie"
            data-size="200"
            data-center-text="300">
            <ul>
                <li>
                    Direct <span>100</span>
                </li>
                <li>
                    Organic <span>120</span>
                </li>
                <li>
                    Referral <span>80</span>
                </li>
            </ul>
        </div>

        <h4>
            Bar Chart
        </h4>
        <div
            class="control-chart wrap-legend"
            data-control="chart-bar"
            data-height="100"
            data-full-width="1">
            <ul>
                <li>
                    Jan <span>150</span>
                </li>
                <li>
                    Feb <span>200</span>
                </li>
                <li>
                    Mar <span>180</span>
                </li>
                <li>
                    Apr <span>250</span>
                </li>
            </ul>
        </div>

        <h4>
            Line Chart
        </h4>
        <div
            data-control="chart-line"
            data-time-mode="weeks"
            style="height: 200px"
            data-chart-options="xaxis: {mode: 'time'}">
            <span
                data-chart="dataset"
                data-set-color="#008dc9"
                data-set-data="[1477857082000, 400], [1477943482000, 380], [1478029882000, 340], [1478116282000, 540], [1478202682000, 440], [1478289082000, 360], [1478375482000, 220]"
                data-set-name="Visits">
            </span>
        </div>

    <?php else: ?>
        <p class="flash-message static warning">
            <?= e($error) ?>
        </p>
    <?php endif ?>
</div>
