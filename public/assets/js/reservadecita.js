function reservacita() {
    const now = new Date();
    const timezoneOffset = now.getTimezoneOffset() * 60000; // Obtener el desfase en milisegundos

    const appointment_date = new Date(now - timezoneOffset)
        .toISOString()
        .slice(0, 10);

    return {
        tipo_terapia_id: "",
        tipo_problema_id: "",
        problemas_bag: [],

        disableButton: true,
        tipos_terapia_especialista: [],
        especialistas: "",
        tipo_de_terapia_name: "",
        hayespecialistas: false,
        dias_atencion: "",
        mensaje: "",
        horarios: [],
        tipo_de_problema_name: "",
        motivo_consulta: "",
        horario: "",
        paciente_name: "",
        menores: false,

        nuevoarrayhoras: [],
        selectedTherapist: false,

        formData: {
            now: timezoneOffset,

            name: "",
            lastname: "",
            email: "",
            phone: "",
            gender: "",

            appointment_date: appointment_date,

            schedule: "",

            apoderado: "",
            especialista: "",
            tipo_terapia: "",
            tipo_problema: "",
        },

        resume_pane: false,

        ReservaForm() {
            this.formData.schedule = this.horario;

            /*this.formData.cause = this.motivo_consulta*/
            //this.formData.cause= 'necesitan consejo, proceso y eso?'

            this.formData.tipo_terapia = this.tipo_terapia_id;
            this.formData.tipo_problema = this.tipo_problema_id;

            Swal.fire({
                icon: "warning",

                title: "Está seguro de los datos para la reserva?",

                cancelButtonText: "No",

                showCancelButton: true,
            }).then((opt) => {
                if (opt.isConfirmed) {
                    fetch("reservas", {
                        method: "POST",

                        headers: {
                            "Content-Type": "application/json",

                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },

                        body: JSON.stringify(this.formData),
                    }).then((r) => r.json());

                    /*.then((data) => {
                            if (data == 1) {
                                Swal.fire({
                                    title: "El horario ya está reservado ",

                                    text: "Ya existe una reserva con ese especialista a la hora seleccionada. Porfavor seleccione un horario diferente o una fecha diferente.",

                                    icon: "warning",

                                    confirmButtonColor: "#3085d6",

                                    confirmButtonText: "Ok",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        })
                        .catch((data) => {
                            console.log("Error"),
                                Swal.fire({
                                    icon: "error",

                                    title: "Oops...",

                                    text: "Algo salió mal",

                                    html: "<h4>Asegurate de que completaste todo el formulario.</h4>",
                                });
                        });*/
                }
            });
        },
        get horario_de_consulta_prop() {
            const nuevoarrayhoras = this.horarios;

            for (let i = 0; i < nuevoarrayhoras.length; i++) {
                if (nuevoarrayhoras[i].id == this.horario) {
                    return nuevoarrayhoras[i].schedule;
                }
            }
        },
        get fecha_actual() {
            var today = new Date();

            // `getDate()` devuelve el día del mes (del 1 al 31)
            var day = today.getDate();

            // `getMonth()` devuelve el mes (de 0 a 11)
            var month = today.getMonth() + 1;

            var year = today.getFullYear();

            if (month.toString().length == 1) {
                month = `0${month}`;
            }

            if (day.toString().length == 1) {
                day = `0${day}`;
            }
            return `${year}-${month}-${day}`;
        },
        get fecha_actual_mas_1() {
            var dias_a_partir_de_hoy = 1;
            return moment(this.fecha_actual).add(1, "day").format("YYYY-MM-DD");
        },
        validarfecha() {
            const fecha = this.formData.appointment_date;
            if (moment(fecha).day() === 0) {
                alert(
                    "No se puede seleccionar el dia domingo. Porfavor seleccione otra fecha"
                );
            }
        },
        setPacienteName(event) {
            var selectedOption =
                event.target.options[event.target.selectedIndex];
            var PacienteName = selectedOption.getAttribute("data-paciente");
            this.paciente_name = PacienteName;
        },
        psicologos(param) {
            fetch(`horarios_psicologos/${param}`)
                .then((r) => r.json())

                .then((data) => {
                    this.horarios = data;
                    console.log(this.horarios);
                })

                .catch();
        },
        seleccionarespecialista(event) {
            var selectedOption =
                event.target.options[event.target.selectedIndex];
            var ProblemName = selectedOption.getAttribute("data-name");
            this.tipo_de_problema_name = ProblemName;

            var especialistaEnTerapia = this.tipo_terapia_id;
            var especialistaEnProblema = this.tipo_problema_id;

            fetch(
                `seleccionar_especialista/${especialistaEnTerapia}/${especialistaEnProblema}`
            )
                .then((r) => r.json())
                .then((data) => {
                    this.especialistas = data;
                    this.hayespecialistas = true;
                    this.dias_atencion = this.especialistas.works_at_hours;
                    this.tipos_terapia_especialista =
                        data[0].therapies_offered[0];
                    this.mensaje = "";
                    console.log(data);

                    if (especialistaEnTerapia == 3) {
                        this.menores = true;
                    }
                })
                .catch((data) => {
                    this.mensaje =
                        "Aún no hay especialistas para el tipo de terapia y tipo de problema seleccionado";
                });
        },
        tipo_problema(event) {
            var selectedOption =
                event.target.options[event.target.selectedIndex];
            var terapiaName = selectedOption.getAttribute("data-name");
            this.tipo_de_terapia_name = terapiaName;

            fetch(
                `consulta_problemas/${this.tipo_terapia_id}`,

                {
                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",

                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },

                    body: JSON.stringify(this.tipo_terapia_id),
                }
            )
                .then((r) => r.json())
                .then((data) => {
                    this.problemas_bag = data;
                })
                .catch();
        },
    };
}
