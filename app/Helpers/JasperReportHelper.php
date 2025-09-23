<?php

if (!function_exists('jasper_generate')) {
    /**
     * Generate Jasper report
     *
     * @param string $reportPath เช่น "/backroomweb/test_report"
     * @param array  $params     เช่น ['start_date' => '2025-09-01']
     * @param string $format     html, xml, pdf, xlsx, xls, rtf, csv, odt, docx, ods, pptx
     * @return array             ['status' => int, 'content' => string|null, 'error' => string|null, 'url' => string]
     */
    function jasper_generate(string $reportPath, array $params = [], string $format = 'pdf'): array
    {
        $baseUrl  = config('jasper.jrs_base_url');
        $username = config('jasper.jrs_username');
        $password = config('jasper.jrs_password');
        $folder   = config('jasper.jrs_folder', '/reports');

        // validate format
        $allowedFormats = ['html', 'xml', 'pdf', 'xlsx', 'xls', 'rtf', 'csv', 'odt', 'docx', 'ods', 'pptx'];
        if (!in_array(strtolower($format), $allowedFormats)) {
            return [
                'status'  => 400,
                'content' => null,
                'error'   => "Unsupported format: $format",
                'url'     => null,
            ];
        }

        $mimeMap = [
            'pdf'  => 'application/pdf',
            'html' => 'text/html',
            'xml'  => 'application/xml',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xls'  => 'application/vnd.ms-excel',
            'rtf'  => 'application/rtf',
            'csv'  => 'text/csv',
            'odt'  => 'application/vnd.oasis.opendocument.text',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];

        $mime = $mimeMap[strtolower($format)] ?? 'application/octet-stream';

        // build url
        $url = rtrim($baseUrl, '/') . "/rest_v2/reports" . $folder . $reportPath . "." . strtolower($format);
        $url .= "?j_username=" . urlencode($username) . "&j_password=" . urlencode($password);

        foreach ($params as $key => $value) {
            $url .= "&" . urlencode($key) . "=" . urlencode($value);
        }

        // curl
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, config('jasper.jrs_timeout', 10));

            $content = curl_exec($ch);
            $curlErr = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($curlErr) {
                return [
                    'status'  => 500,
                    'content' => null,
                    'error'   => $curlErr,
                    'url'     => $url,
                ];
            }

            return [
                'status'  => $httpCode,
                'content' => ($httpCode === 200) ? $content : null,
                'mime'    => $mime,
                'error'   => ($httpCode === 200) ? null : "HTTP error code: $httpCode",
                'url'     => $url,
            ];
        } catch (\Exception $e) {
            return [
                'status'  => 500,
                'content' => null,
                'error'   => $e->getMessage(),
                'url'     => $url,
            ];
        }
    }
}

if (!function_exists('jasper_test_connection')) {
    function jasper_test_connection(): string
    {
        $baseUrl  = config('jasper.jrs_base_url');
        $username = config('jasper.jrs_username');
        $password = config('jasper.jrs_password');

        if (empty($baseUrl)) {
            return 'Invalid configuration: jrs_base_url is not set';
        }

        $url = rtrim($baseUrl, '/') . '/rest_v2/resources';
        $query = [];

        if ($username !== null) {
            $query['j_username'] = $username;
        }
        if ($password !== null) {
            $query['j_password'] = $password;
        }

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        // $content  = curl_exec($ch);
        $curlErr  = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($curlErr) {
            return "❌ Connection failed: $curlErr";
        }

        return ($httpCode === 200) ? ' ✅ Connect Success' : "Connect Failed (HTTP $httpCode)";
    }
}
