$ProgressPreference = 'SilentlyContinue'
Remove-Item .\storage_jar.txt -ErrorAction SilentlyContinue

$loginHtml = (curl.exe -s -c storage_jar.txt http://127.0.0.1:8000/admin/login) -join "`n"
$token = [regex]::Match($loginHtml, 'name="_token" value="([^"]+)"').Groups[1].Value

curl.exe -s -b storage_jar.txt -c storage_jar.txt -o NUL --data "email=jishovon@gmail.com&password=12345678&_token=$token" http://127.0.0.1:8000/admin/login

$raw = ((curl.exe -s -b storage_jar.txt http://127.0.0.1:8000/admin/events/grand-alumni-reunion-2026/edit) -join "`n")
Write-Output ("page length: " + $raw.Length)
$idx = $raw.IndexOf('id="cover_image"')
if ($idx -lt 0) { $idx = $raw.IndexOf('cover_image') }
Write-Output ("cover_image idx: " + $idx)
if ($idx -ge 0) {
    $start = [Math]::Max(0, $idx - 1500)
    Write-Output $raw.Substring($start, [Math]::Min(2600, $raw.Length - $start))
}