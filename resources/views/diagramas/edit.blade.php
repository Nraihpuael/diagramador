@section('title', 'Editar Diagrama')
<x-app-layout>
    <div class="page bg-black">
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page title -->
                <div class="page-header d-print-none">
                    <div class="row g-2 align-items-center">
                        <div class="col-6">
                            <h2 class="page-title">
                                Editando Informacion del Diagrama
                            </h2>
                        </div>
                        <!-- Page title actions -->
                        <div class="col-auto">
                            <a href="{{ route('diagramas.misDiagramas')}}" class="btn btn-secondary">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <form action="{{ route('diagramas.update', $diagrama->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="container-xl">
                        <div class="row row-cards">
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <div class="form-label">Nombre del Diagrama</div>
                                                <input name="nombre" type="text"
                                                    class="form-control"
                                                    value="{{ $diagrama->nombre }}" required>
                                                @error('name')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            
                                            <div class="mt-3">
                                                <div class="row g-3">
                                                    <div class="col-md-10 ">
                                                        <div class="form-label ">Descripcion</div>
                                                        <textarea name="descripcion" class="form-control" rows="3" required>{{ $diagrama->descripcion }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent mt-2">
                                    <div class="btn-list justify-content-begin">
                                        <button type="submit" class="btn btn-black">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    @push('scripts')
        <script>
            const svgp = document.getElementById('svg');
            const svg = svgp.childNodes[3];
            console.log(svg);
            const {
                x,
                y,
                width,
                height
            } = svg.viewBox.baseVal;
            const blob = new Blob([svg.outerHTML], {
                type: 'image/svg+xml'
            });
            const url = URL.createObjectURL(blob);
            const image = document.createElement('img');
            image.src = url;
            image.addEventListener('load', () => {
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const context = canvas.getContext('2d');
                context.drawImage(image, x, y, width, height);
                let link = document.getElementById('descargar');
                link.href = canvas.toDataURL();
                URL.revokeObjectURL(url);
            })
        </script>
        <script>
            let verImagen = (event) => {
                let leer_img = new FileReader();
                let id_img = document.getElementById('perfil');

                leer_img.onload = () => {
                    if (leer_img.readyState == 2) {
                        id_img.src = leer_img.result;
                    }
                }
                leer_img.readAsDataURL(event.target.files[0])
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                window.Litepicker && (new Litepicker({
                    element: document.getElementById('datepicker-icon'),
                    buttonText: {
                        previousMonth: `
            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <polyline points="15 6 9 12 15 18" />
            </svg>`,
                        nextMonth: `
            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <polyline points="9 6 15 12 9 18" />
            </svg>`,
                    },
                }));
            });
        </script>
    @endpush
</x-app-layout>
