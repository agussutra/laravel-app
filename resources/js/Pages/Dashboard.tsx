import { PageProps } from '@/types';
import Page from '@/Layouts/Page';

export default function Dashboard({ auth }: PageProps) {
    return (
            <Page auth={auth} header='Dashboard'>
                <span>Welcome!</span>
            </Page>
    );
}
