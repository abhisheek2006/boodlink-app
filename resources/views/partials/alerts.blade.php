@if ($errors->any() && $errors->count() > 1)
    <div class="bl-error-alert">

        <div class="bl-error-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <div class="bl-error-content">

            <div class="bl-error-title">
                Please fix the following errors
            </div>

            <ul class="bl-error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    </div>
@endif

<style>
    .bl-error-alert {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        margin-bottom: 20px;
        padding: 15px 17px;
        background: #fff7f7;
        border: 1px solid #ffd9dd;
        border-left: 4px solid #ef233c;
        border-radius: 12px;
        color: #172033;
    }

    .bl-error-icon {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 10px;
        background: #ffe8eb;
        color: #ef233c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .bl-error-content {
        flex: 1;
    }

    .bl-error-title {
        margin-bottom: 6px;
        color: #b91c1c;
        font-size: 13px;
        font-weight: 700;
    }

    .bl-error-list {
        margin: 0;
        padding-left: 18px;
        color: #6b7280;
        font-size: 12px;
        line-height: 1.7;
    }

    .bl-error-list li {
        padding-left: 2px;
    }

    @media (max-width: 576px) {
        .bl-error-alert {
            padding: 13px;
        }

        .bl-error-icon {
            width: 32px;
            height: 32px;
            min-width: 32px;
        }
    }
</style>