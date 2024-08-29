import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { Toaster } from 'react-hot-toast';
export default function Page({ children, auth, header }: { children: React.ReactNode, auth: any, header: string }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">{header}</h2>}
        >
            <Head title={header} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
                        <Toaster />
                        {children}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}