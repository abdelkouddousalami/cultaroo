<!DOCTYPE html>
<html>
<head>
    <title>Debug Host Application</title>
    @include('partials.favicon')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Debug Host Application Form</h1>
    
    <div id="debug-output"></div>
    
    <form id="debug-form" enctype="multipart/form-data">
        @csrf
        <p><strong>Step 1: Fill out this simple form</strong></p>
        
        <div>
            <label>City:</label>
            <input type="text" name="city" value="Test City" required>
        </div>
        
        <div>
            <label>Family Size:</label>
            <select name="family_members_count" required>
                <option value="2">2 people</option>
            </select>
        </div>
        
        <div>
            <label>Languages:</label>
            <input type="checkbox" name="languages[]" value="Arabic" checked> Arabic
            <input type="checkbox" name="languages[]" value="English" checked> English
        </div>
        
        <div>
            <label>Amenities:</label>
            <input type="checkbox" name="amenities[]" value="WiFi" checked> WiFi
            <input type="checkbox" name="amenities[]" value="Kitchen" checked> Kitchen
        </div>
        
        <div>
            <label>Motivation:</label>
            <textarea name="motivation" required>This is a test motivation with more than 50 characters to pass validation requirements.</textarea>
        </div>
        
        <div>
            <label>National ID (fake file):</label>
            <input type="file" name="national_id_document" required>
        </div>
        
        <div>
            <label>House Document (fake file):</label>
            <input type="file" name="house_ownership_document" required>
        </div>
        
        <button type="submit">Submit Debug Form</button>
    </form>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        function log(message) {
            console.log(message);
            const output = document.getElementById('debug-output');
            output.innerHTML += '<p>' + message + '</p>';
        }
        
        document.getElementById('debug-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            log('🚀 Form submitted!');
            
            const formData = new FormData(this);
            
            // Log all form data
            log('📋 Form data:');
            for (let [key, value] of formData.entries()) {
                if (value instanceof File) {
                    log(`${key}: File "${value.name}" (${value.size} bytes)`);
                } else {
                    log(`${key}: ${value}`);
                }
            }
            
            try {
                log('🌐 Sending request to /host-application...');
                
                const response = await fetch('/host-application', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                log(`📨 Response: ${response.status} ${response.statusText}`);
                
                const responseText = await response.text();
                log(`📊 Response body: ${responseText}`);
                
                if (response.ok) {
                    const data = JSON.parse(responseText);
                    if (data.success) {
                        log('✅ SUCCESS: ' + data.message);
                    } else {
                        log('❌ FAILED: ' + (data.message || 'Unknown error'));
                        if (data.errors) {
                            log('Validation errors: ' + JSON.stringify(data.errors));
                        }
                    }
                } else {
                    log('❌ HTTP ERROR: ' + response.status);
                }
                
            } catch (error) {
                log('💥 JavaScript error: ' + error.message);
            }
        });
    </script>
</body>
</html>
