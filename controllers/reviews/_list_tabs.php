<div class="control-tabs pill-tabs is-vertical">
    <ul class="nav nav-tabs" data-disposable="" role="tablist">
        <li class="<?= !get('filter') ? 'active' : '' ?>">
            <a href="?">
                <span class="title">
                    <span>All Reviews</span>
                </span>
            </a>
        </li>
        <li class="<?= get('filter') === 'positive' ? 'active' : '' ?>">
            <a href="?filter=positive">
                <span class="title">
                    <span>Positive</span>
                </span>
            </a>
        </li>
        <li class="<?= get('filter') === 'negative' ? 'active' : '' ?>">
            <a href="?filter=negative">
                <span class="title">
                    <span>Negative</span>
                </span>
            </a>
        </li>
    </ul>
</div>
