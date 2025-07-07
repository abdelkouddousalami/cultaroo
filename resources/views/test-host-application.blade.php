<!DOCTYPE html>
<html>
<head>
    <title>Test Host Application</title>
    @include('partials.favicon')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test Host Application Submission</h1>
    
    <form id="test-form">
        <input type="file" name="national_id_document" accept=".pdf,.jpg,.jpeg,.png" required>
        <input type="file" name="house_ownership_document" accept=".pdf,.jpg,.jpeg,.png" required>
        <input type="text" name="city" placeholder="City" required>
        <select name="family_members_count" required>
            <option value="">Select family size</option>
            <option value="1">1 person</option>
            <option value="2">2 people</option>
        </select>
        <input type="checkbox" name="languages[]" value="Arabic"> Arabic
        <input type="checkbox" name="languages[]" value="English"> English
        <input type="checkbox" name="amenities[]" value="WiFi"> WiFi
        <input type="checkbox" name="amenities[]" value="Kitchen"> Kitchen
        <textarea name="motivation" placeholder="Why do you want to be a host?" required></textarea>
        <button type="submit">Submit Test Application</button>
    </form>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        document.getElementById('test-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log('Test form submitted');
            
            const formData = new FormData(this);
            
            try {
                console.log('Sending request...');
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
                
                alert(JSON.stringify(data));
            } catch (error) {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            }
        });
    </script>
</body>
</html>
