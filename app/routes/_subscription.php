<?php

use App\Controllers\SubscriptionController;

app()->post('/subscription', function () {
    return app()->{SubscriptionController::class}->create();
});

app()->delete('/subscription/{id}', function (string $id) {
    return app()->{SubscriptionController::class}->deleteById($id);
});

app()->get('/subscriptions', function () {
    return app()->{SubscriptionController::class}->getAll();
});
