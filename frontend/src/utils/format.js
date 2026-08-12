const CURRENCY_SYMBOLS = {
    USD: '$',
    EUR: '€',
    GBP: '£',
    JPY: '¥',
    INR: '₹',
    BDT: '৳',
    CAD: 'C$',
    AUD: 'A$',
    CNY: '¥',
    BRL: 'R$',
    KRW: '₩',
    MXN: 'Mex$',
    SEK: 'kr',
    NOK: 'kr',
    DKK: 'kr',
    CHF: 'CHF',
    PLN: 'zł',
    CZK: 'Kč',
    ZAR: 'R',
    SGD: 'S$',
    HKD: 'HK$',
}

let currentCurrency = 'USD'

export function setCurrency(code) {
    if (code && CURRENCY_SYMBOLS[String(code).toUpperCase()]) {
        currentCurrency = String(code).toUpperCase()
    }
}

export function getCurrency() {
    return currentCurrency
}

export function getCurrencySymbol() {
    return CURRENCY_SYMBOLS[currentCurrency] || `${currentCurrency} `
}

export function formatPrice(value) {
    const num = Number(value || 0)
    const formatted = num.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })
    return `${getCurrencySymbol()}${formatted}`
}

export function formatDate(value) {
    if (!value) return '—'
    const date = new Date(value)
    if (Number.isNaN(date.getTime())) return '—'
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    })
}

export function formatDateTime(value) {
    if (!value) return '—'
    const date = new Date(value)
    if (Number.isNaN(date.getTime())) return '—'
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    })
}

export const STATUS_LABELS = {
    pending: 'Pending',
    processing: 'Processing',
    shipped: 'Shipped',
    completed: 'Completed',
    cancelled: 'Cancelled',
}

export const PAYMENT_LABELS = {
    pending: 'Pending',
    paid: 'Paid',
    failed: 'Failed',
    cod: 'Cash on Delivery',
    stripe: 'Card',
}

export const STATUS_STYLES = {
    pending: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
    processing: 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
    shipped: 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
    completed: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
    cancelled: 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
}

export const STOCK_STYLES = {
    in_stock: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
    low_stock: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
    out_of_stock: 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
}

export function stockLabel(status) {
    const labels = { in_stock: 'In Stock', low_stock: 'Low Stock', out_of_stock: 'Out of Stock' }
    return labels[status] || status
}
