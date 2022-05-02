<div class="form-control" style="height: auto">
    <pre><?= json_encode([
        'images' => $model->image_properties,
        'properties' => $model->properties,
    ], JSON_PRETTY_PRINT) ?></pre>
</div>
