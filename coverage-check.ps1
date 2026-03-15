Set-Location $PSScriptRoot
$required = Get-Content .\required-files.txt | Where-Object { $_ -and $_.Trim() -ne '' }
$missing = $required | Where-Object { -not (Test-Path $_) }
if ($missing.Count -eq 0) {
    Write-Output 'Coverage check: OK'
} else {
    Write-Output 'Coverage check: FAIL'
    $missing | ForEach-Object { Write-Output $_ }
}
