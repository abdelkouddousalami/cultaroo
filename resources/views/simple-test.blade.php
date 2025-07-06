<!DOCTYPE html>
<html>
<head>
    <title>Simple Host Application Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Simple Host Application Test</h1>
    
    <button onclick="testSimpleRequest()">Test Simple Request</button>
    
    <form id="simple-form">
        <input type="text" name="city" placeholder="City" value="Test City" required>
        <select name="family_members_count" required>
            <option value="2">2 people</option>
        </select>
        <input type="checkbox" name="languages[]" value="Arabic" checked> Arabic
        <input type="checkbox" name="amenities[]" value="WiFi" checked> WiFi
        <textarea name="motivation" required>This is a test motivation that is long enough to pass validation.</textarea>
        <button type="submit">Submit Simple Application</button>
    </form>
    
    <div id="result"></div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        function testSimpleRequest() {
            fetch('/test-route', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').innerHTML = 'Test route result: ' + JSON.stringify(data);
            })
            .catch(error => {
                document.getElementById('result').innerHTML = 'Test route error: ' + error.message;
            });
        }
        
        document.getElementById('simple-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log('Simple form submitted');
            
            const formData = new FormData(this);
            
            // Add fake files to test without actual file uploads
            const fakeFile = new File(['fake content'], 'test.txt', { type: 'text/plain' });
            formData.append('national_id_document', fakeFile);
            formData.append('house_ownership_document', fakeFile);
            
            try {
                console.log('Sending simple request...');
                const response = await fetch('/host-application', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                console.log('Response status:', response.status);
                const data = await response.json();
                console.log('Response data:', data);
                
                document.getElementById('result').innerHTML = 'Application result: ' + JSON.stringify(data);
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('result').innerHTML = 'Application error: ' + error.message;
            }
        });
    </script>
</body>
</html>
