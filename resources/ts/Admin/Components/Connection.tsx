import * as React from 'react';
import ConnectionInfo from './ConnectionInfo';
import ConnectionActions from './ConnectionActions';


import { 
	Flex
} from '@wordpress/components';

interface ConnectionProps {
	user: any;
}

export default function Connection( props: ConnectionProps ) {
	return (
		<Flex
			//@ts-ignore
			direction="column"
			gap={4}
		>
			<ConnectionInfo status={ props?.user?.can_connect } user={ props?.user } />
			<ConnectionActions disabled={ !props?.user } status={ props?.user?.can_connect } />
		</Flex>
	);
}
 

