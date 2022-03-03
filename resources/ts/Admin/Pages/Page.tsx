import * as React from 'react';
import BackButton from '../Components/BackButton';

import { 
	Flex,
} from '@wordpress/components';

import { 
	Fragment,
} from '@wordpress/element';
import IntegrationNotConnectedNotice from '../Components/Notices/IntegrationNotConnectedNotice';
import UserNotConnectedNotice from '../Components/Notices/UserNotConnectedNotice';

interface PageProps {
	title: string,
	children: any;
}

export default function Page( props: PageProps ) {

	return (
		<Fragment>
			<Flex
				//@ts-ignore
				direction="column"
				style={ { margin: '12px 0' } }
			>
				<IntegrationNotConnectedNotice />
				<UserNotConnectedNotice />
			</Flex>
			
			<h2>{ props.title }</h2>
			<BackButton />
			<div style={ { marginTop: '8px' } } >
				{ props.children }
			</div>
		</Fragment>
	)
}
