import Modal from "@/Components/Modal";
import PrimaryButton from "@/Components/PrimaryButton";
import { Fragment } from "react/jsx-runtime";
import { UserType } from "../types";
import { FormEventHandler, useState } from "react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import { useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import toast from "react-hot-toast";

export function Action({ action, data }: { action: string, data?: UserType | undefined }) {
    const [show, setShow] = useState<boolean>(false);
    return (
        <Fragment>
            {action === 'UPDATE' && <PrimaryButton onClick={() => setShow(true)} className='bg-yellow-400 hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-300 focus:ring-yellow-300'>Update</PrimaryButton>}
            {action === 'DELETE' && <PrimaryButton onClick={() => setShow(true)} className='bg-red-400 hover:bg-red-500 focus:bg-red-500 active:bg-red-300 focus:ring-red-300'>Delete</PrimaryButton>}
            {action === 'CREATE' && <PrimaryButton onClick={() => setShow(true)} className='mb-4'>New User</PrimaryButton>}

            {show && <FormAction setShow={setShow} data={data} action={action} />}

        </Fragment>
    )
}

function FormAction(props: {
    setShow: (value: boolean) => void,
    data?: UserType,
    action: string
}) {

    const { data, setData, post,put, delete: destroy, processing, errors, reset } = useForm({
        name: props.data?.name,
        email: props.data?.email,
        password: '',
    })

    const submit: FormEventHandler = (e) => {
        
        e.preventDefault();
        if (props.action === 'CREATE') {
            post(route('users.store'), {
                onSuccess: () => {
                    reset('password');
                    props.setShow(false);
                    toast.success('Users Successfully Created');
                },
                onError: () => {
                }
            })
        } else if (props.action === 'UPDATE') {
            put(route('users.update', props.data?.id), {
                onSuccess: () => {
                    reset('password');
                    props.setShow(false);
                    toast.success('Users Successfully Updated');
                },
                onError: () => {
                }
            })
        } else {
            destroy(route('users.destroy', props.data?.id), {
                onFinish: () => {
                    props.setShow(false);
                    toast.success('Users Successfully Deleted');
                }
            })
        }
    }

    return (
        <Modal
            show={true}
            onClose={() => props.setShow(false)}
            maxWidth="md"
        >
            <div className="ml-3 my-3">
                <h1><b>{props.action}</b></h1>
            </div>
            <div className="px-4 pt-4 pb-6">
                <form onSubmit={submit}>

                    <div>
                        <InputLabel htmlFor="name" value="Name" />
                        <TextInput
                            id="name"
                            type="text"
                            name="name"
                            isFocused={true}
                            value={data.name}
                            disabled={props.action === 'DELETE'}
                            className="mt-1 block w-full"
                            onChange={(e) => setData('name', e.target.value)}
                        />
                        <InputError message={errors.name} className="mt-2" />
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="email" value="E-Mail" />
                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            isFocused={true}
                            value={data.email}
                            disabled={props.action === 'DELETE'}
                            className="mt-1 block w-full"
                            onChange={(e) => setData('email', e.target.value)}
                        />
                         <InputError message={errors.email} className="mt-2" />
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            isFocused={true}
                            disabled={props.action === 'DELETE'}
                            value={data.password}
                            className="mt-1 block w-full"
                            onChange={(e) => setData('password', e.target.value)}
                        />
                         <InputError message={errors.password} className="mt-2" />
                    </div>

                    <div className="mt-6 flex justify-end">
                        <PrimaryButton className="ms-4" disabled={processing}>
                            {props.action === 'CREATE' ? 'Create' : (props.action === 'UPDATE' ? 'Update' : 'Delete')}
                        </PrimaryButton>
                    </div>

                </form>
            </div>
        </Modal>
    )
}