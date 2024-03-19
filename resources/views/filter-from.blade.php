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
                       <a href="{{ route('file-records-show')}}"><button type="button" class="btn btn-primary m-2 float-right">My Table</button></a>
                 
              

                    <div class="container">
<form action="{{route('filter')}}" method="GET">
    @csrf
  <div class="form-row">
   <div class="form-group col-md-4">
      <label for="inputState">Name</label>
      <input type="text" class="form-control" name="name" id="inputAddress" placeholder="Search By Name">
    </div>
 <div class="form-group col-md-4">
      <label for="inputState">Industry</label>
            <input type="text" class="form-control" name="indus" id="inputAddress" placeholder="Search By Industry">
    </div>
  <div class="form-group col-md-4">
      <label for="inputState">Locality</label>
           <input type="text" class="form-control" name="locality" id="inputAddress" placeholder="Search By Locality">
    </div>
    </div>
  <button type="submit" class="btn btn-primary">Filter</button>
</form>
                </div>
            </div>
        </div>
    </div>

    
<script>
   document.getElementById('resumable-browse').addEventListener('change', function(event) {
     document.getElementById('resumable-browse').disabled  = true;
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
 var chunksUploaded = 0;
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
         chunksUploaded++;

            let progressPercentage = Math.ceil((chunksUploaded / totalChunks) * 100);
            document.getElementById('resumable-browse').disabled  = true;
            document.getElementById('upload-progress').style.width = progressPercentage + "%";
             document.getElementById('upload-progress').innerText = progressPercentage + "%";
             if (progressPercentage === 100) {
                swal({
                        title: "Records Uploaded Successfully",
                        text: "Click Ok to Check Records",
                        icon: "success",
                    }).then(function () {
                        var baseUrl = window.location.origin;
                        window.location = baseUrl + '/file-records';
                    })
                    document.getElementById('resumable-browse').disabled  = false;
             }
           
    })
    .catch(error => {
        console.error('Error processing CSV chunk:', error);
    });

}

</script>
</x-app-layout>