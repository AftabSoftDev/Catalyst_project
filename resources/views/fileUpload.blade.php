<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- <b>Users Table</b><br> --}}
                    <a href="{{ route('dashboard') }}"><button type="button"
                            class="btn btn-secondary mb-4  float-right">Back</button></a>
                    <div class="container">
                      <form id="fileUpload">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Upload CSV</span>
        </div>
        <div class="custom-file">
            <!-- Add an ID to the file input field -->
            <input type="file" class="custom-file-input" name="uploaded_file" id="resumable-browse"
                aria-describedby="inputGroupFileAddon01" accept=".csv">
            <label class="custom-file-label" for="resumable-browse">Choose file</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mb-4 float-right" name="submit">Upload</button>
</form>
<div class="progress" id="progress">
    <div class="progress-bar" role="progressbar" id="upload-progress" >0%</div>
</div>
                </div>
            </div>
        </div>
    </div>

    
<script>
   document.getElementById('resumable-browse').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var chunkSize = 1024 * 1024; 
    var chunks = Math.ceil(file.size / chunkSize);

    for (let i = 0; i < chunks; i++) {
        let start = i * chunkSize;
        let end = Math.min(start + chunkSize, file.size);
        let chunk = file.slice(start, end);

        readAndProcessChunk(chunk, i, chunks);
    }
});

function readAndProcessChunk(chunk, chunkIndex, totalChunks) {
    var reader = new FileReader();
    reader.onload = function(e) {
        var csvData = e.target.result;
        uploadCsvChunk(csvData, chunkIndex, totalChunks);
    };
    reader.readAsText(chunk);
}

function uploadCsvChunk(csvData, chunkIndex, totalChunks) {
    fetch("{{ route('file-uploads') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            csvData: csvData,
            chunkIndex: chunkIndex,
            totalChunks: totalChunks
        })
    })
    .then(response => response.json())
    .then(data => {
   
        console.error('Error processing CSV chunk:', error);
        var progress = ((chunkIndex + 1) / totalChunks) * 100;
        updateProgressBar(progress);
    })
    .catch(error => {
        console.error('Error processing CSV chunk:', error);
    });
}
function updateProgressBar(progress) {
    
    document.getElementById('progress').style.display = "block";
    document.getElementById('upload-progress').style.width = progress;
    document.getElementById('upload-progress').innerText = progress + '%';
    console.log(progress);
}
</script>
</x-app-layout>