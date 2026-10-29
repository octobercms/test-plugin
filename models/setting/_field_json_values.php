<div class="form-control" style="height: auto">
    <pre><?= e(json_encode([
        'images' => $model->image_properties,
        'properties' => $model->properties,
    ], JSON_PRETTY_PRINT)) ?></pre>
</div>
