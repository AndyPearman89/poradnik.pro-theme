Set-Location $PSScriptRoot
$failed = @()
Get-ChildItem -Recurse -File -Filter *.php | ForEach-Object {
    php -l $_.FullName | Out-Null
    if ($LASTEXITCODE -ne 0) {
        $failed += $_.FullName
    }
}

if ($failed.Count -eq 0) {
    Write-Output 'PHP lint: OK'
} else {
    Write-Output 'PHP lint: FAIL'
    $failed | ForEach-Object { Write-Output $_ }
}
