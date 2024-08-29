import PrimaryButton from '@/Components/PrimaryButton';
import Page from '@/Layouts/Page';
import { PageProps } from '@/types';
import { UserType } from './types';
import { Action } from './Action';
import toast, { Toaster } from 'react-hot-toast';

export default function Users(props: {
    auth: PageProps,
    users: UserType[]
}) {

    return (
        <Page auth={props.auth} header='Users'>
           <Action action='CREATE'/>
            <div className="relative overflow-x-auto">
                <table className="w-full text-sm text-left rtl:text-right ">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 ">
                        <tr>
                            <th scope="col" className="px-6 py-3">
                                No
                            </th>
                            <th scope="col" className="px-6 py-3">
                                User Name
                            </th>
                            <th scope="col" className="px-6 py-3">
                                E-Mail
                            </th>
                            <th scope="col" className="px-2 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {props.users.map((item, index) => (
                        <tr key={index}>
                            <td className="px-6 py-4">
                                {index + 1}
                            </td>
                            <td className="px-6 py-4">
                                {item.name}
                            </td>
                            <td className="px-6 py-4">
                                {item.email}
                            </td>
                            <td className="px-2 py-4">
                                <div className='flex gap-2'>
                                    <Action action='UPDATE' data={item} />
                                    <Action action='DELETE' data={item} />
                                </div>
                            </td>
                        </tr>
                        ))}
                    </tbody>
                </table>
            </div>

        </Page>
    )
} 