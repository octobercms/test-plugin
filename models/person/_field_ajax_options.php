<?php /* Testing an AJAX select that depends on the People::onGetOptions handler, so it only loads options on the People form */ ?>
<select
    class="form-control custom-select"
    data-handler="onGetOptions"
    data-minimum-input-length="2"
    data-ajax--delay="300"
    data-request-data="foo: 'bar'"
    ></select>
