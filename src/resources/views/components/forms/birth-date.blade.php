@props([
    'prefix' => '',
    'birthDate' => null,
])

@php
    $prefix = $prefix ? $prefix . '_' : '';
    $selectedYear = old($prefix . 'year', optional($birthDate)->year);
    $selectedMonth = old($prefix . 'month', optional($birthDate)->month);
    $selectedDay = old($prefix . 'day', optional($birthDate)->day);
@endphp

<div>
    <label class="block font-medium text-sm text-gray-700">生年月日</label>
    <div class="flex space-x-2">
        <!-- 年 -->
        <select name="{{ $prefix }}birth_year" class="border rounded p-2" required>
            <option value="">年</option>
            @for ($year = date('Y'); $year >= 1900; $year--)
                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}年</option>
            @endfor
        </select>

        <!-- 月 -->
        <select name="{{ $prefix }}birth_month" class="border rounded p-2" required>
            <option value="">月</option>
            @for ($month = 1; $month <= 12; $month++)
                <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>{{ $month }}月</option>
            @endfor
        </select>

        <!-- 日 -->
        <select name="{{ $prefix }}birth_day" class="border rounded p-2" required>
            <option value="">日</option>
            @for ($day = 1; $day <= 31; $day++)
                <option value="{{ $day }}" {{ $selectedDay == $day ? 'selected' : '' }}>{{ $day }}日</option>
            @endfor
        </select>
    </div>
</div>
