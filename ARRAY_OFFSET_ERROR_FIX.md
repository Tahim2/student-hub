# Fix for "Trying to access array offset on value of type int" Error

## Problem
The CGPA tracker was showing an "Internal Server Error" with the message:
```
ErrorException: Trying to access array offset on value of type int
```

This occurred at line 771 in `resources/views/grades/index.blade.php` when trying to access `$semester['name']`, `$semester['year']`, etc. in the Semester Results Display section.

## Root Cause: Variable Name Conflict

The issue was caused by a **variable name conflict** in the Blade template:

### Conflict Details:
1. **Controller passes `$semesterData`**: An array of semester information for displaying results
2. **First foreach loop (line 581)**: Used `$semesterData` as the loop variable
   ```php
   @foreach($allSemesters as $semesterName => $semesterData)
   ```
3. **Second foreach loop (line 763)**: Tried to use `$semesterData` as the array to iterate
   ```php  
   @foreach($semesterData as $semester)
   ```

### What Happened:
- The first foreach loop overwrote the controller's `$semesterData` array
- By the time the second foreach executed, `$semesterData` contained integer values instead of the array
- When trying to access `$semester['name']`, PHP tried to access array offsets on integers

## Solution Implemented

### Fixed Variable Name Conflict
Changed the first foreach loop to use a different variable name:

**Before:**
```php
@foreach($allSemesters as $semesterName => $semesterData)
    @if($semesterData['is_available_for_input'] || !$semesterData['has_grades'])
        <option value="{{ $semesterData['level'] }}" data-semester="{{ $semesterName }}">Level {{ $semesterData['level'] }}</option>
```

**After:**
```php
@foreach($allSemesters as $semesterName => $semesterInfo)
    @if($semesterInfo['is_available_for_input'] || !$semesterInfo['has_grades'])
        <option value="{{ $semesterInfo['level'] }}" data-semester="{{ $semesterName }}">Level {{ $semesterInfo['level'] }}</option>
```

### Additional Fixes Applied:
1. **Fixed condition check**: Changed `@if(!empty($allSemesters))` to `@if(!empty($semesterData))` for the Semester Results Display section
2. **Improved controller logic**: Added proper integer casting for level and term values extracted from regex matches
3. **Cleared view cache**: Ensured changes are properly compiled

## Files Modified:
- **resources/views/grades/index.blade.php**: Fixed variable name conflict and condition check
- **app/Http/Controllers/GradeController.php**: Improved regex extraction with integer casting

## Result:
- ✅ The "array offset on int" error is resolved
- ✅ The grades page loads successfully 
- ✅ Semester Results Display shows proper data structure
- ✅ Grade input form dropdown works correctly
- ✅ All CGPA calculations remain accurate

## Key Lesson:
Variable name conflicts in Blade templates can cause unexpected data type issues. Always use unique variable names in nested foreach loops to avoid overwriting controller variables.

## Verification:
The page now successfully displays:
- Current CGPA and completed credits
- Semester Results in table format with proper semester names
- Target CGPA Calculator in correct position
- Properly aligned footer without sidebar overlap
