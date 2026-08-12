import { Link } from 'react-router-dom'

export default function NotFoundPage() {
    return (
        <div className="mx-auto flex max-w-lg flex-col items-center gap-4 px-4 py-24 text-center">
            <p className="text-8xl font-extrabold text-brand-100 dark:text-brand-800">404</p>
            <h1 className="text-2xl font-extrabold text-brand-900 dark:text-white">Page not found</h1>
            <p className="text-slate-500 dark:text-slate-400">The page you are looking for doesn't exist or has been moved.</p>
            <Link to="/" className="btn btn-primary mt-2">Back to Home</Link>
        </div>
    )
}
