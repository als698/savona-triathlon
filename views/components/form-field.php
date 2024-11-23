<?php

/**
 * @param string $type Input type
 * @param string $name Field name
 * @param string $label Field label
 * @param string $value Field value
 * @param bool $required Is field required
 */
?>
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="<?= $name ?>">
        <?= $label ?>
    </label>
    <input
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="<?= $name ?>"
        name="<?= $name ?>"
        type="<?= $type ?>"
        value="<?= $value ?? '' ?>"
        <?= $required ? 'required' : '' ?>>
</div>