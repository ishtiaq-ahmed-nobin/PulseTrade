import { Star } from 'lucide-react'

export default function StarRating({ rating = 0, size = 16 }) {
    const rounded = Math.round(rating)

    return (
        <div className="flex items-center gap-0.5">
            {[1, 2, 3, 4, 5].map((star) => (
                <Star
                    key={star}
                    size={size}
                    className={
                        star <= rounded
                            ? 'fill-amber-400 text-amber-400'
                            : 'fill-slate-200 text-slate-200 dark:fill-brand-800 dark:text-brand-800'
                    }
                />
            ))}
        </div>
    )
}
