<style>
    .result-index {
        padding: 48px 0;
        text-align: center;
    }

    .result-index-icon {
        color: #FF5F49;
        font-size: 72px;
    }

    .result-index-title {
        margin-bottom: 16px;
        color: #4a4a4a;
        font-weight: 500;
        font-size: 24px;
        line-height: 32px;
    }

    .result-index-description {
        margin-bottom: 24px;
        color: rgba(0, 0, 0, .55);
        font-size: 14px;
        line-height: 22px;
    }

    .result-index-action {
        margin-top: 32px;
    }
</style>
<div class="main">
    <div class="nodata">
        <div class="test"><?= strip_tags($msg) ?></div>

        <div class="codeForm-btn">
            <div class="codeForm-submit">
                <button type="submit" class="j-submit"><?= lang('go_back'); ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    (function () {
        var href = '<?= $url ?>';
        $('.j-submit').on('click', function () {
            location.href = href;
        });
    })();
</script>
