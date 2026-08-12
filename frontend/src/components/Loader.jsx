export default function Loader({ label = 'Loading...', full = false }) {
    return (
        <div className={`flex flex-col items-center justify-center gap-3 ${full ? 'min-h-[60vh]' : 'py-12'}`}>
            <div className="h-10 w-10 animate-spin rounded-full border-4 border-brand-200 border-t-brand-700 dark:border-brand-800 dark:border-t-brand-400" />
            <p className="text-sm text-slate-500 dark:text-slate-400">{label}</p>
        </div>
    )
}
