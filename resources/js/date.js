import es from 'date-fns/locale/es';
import { format } from 'date-fns';

export function localeFormat(date, formatDate) {
    return format(date, formatDate, { locale: es });
}

export const datepickerOptions = {
    days: [
        'Lunes',
        'Martes',
        'Miercoles',
        'Jueves',
        'Viernes',
        'Sabado',
        'Domingo'
    ],
    daysShort: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
    monthNames: [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Augosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ],
    texts: {
        apply: 'Applicar',
        cancel: 'Cancelar',
        keyboardShortcuts: 'Atajos de teclado'
    },
    keyboardShortcuts: [
        {
            symbol: '↵',
            label: 'Select the date in focus',
            symbolDescription: 'Enter key'
        },
        {
            symbol: '←/→',
            label: 'Move backward (left) and forward (down) by one day.',
            symbolDescription: 'Left or right arrow keys'
        },
        {
            symbol: '↑/↓',
            label: 'Move backward (up) and forward (down) by one week.',
            symbolDescription: 'Up or down arrow keys'
        },
        {
            symbol: 'PgUp/PgDn',
            label: 'Switch months.',
            symbolDescription: 'PageUp and PageDown keys'
        },
        {
            symbol: 'Home/End',
            label: 'Go to the first or last day of a week.',
            symbolDescription: 'Home or End keys'
        },
        {
            symbol: 'Esc',
            label: 'Cerrar este panel',
            symbolDescription: 'Tecla de escape'
        },
        {
            symbol: '?',
            label: 'Abrir este panel',
            symbolDescription: 'Signo de interrogación'
        }
    ]
};
