import * as React from 'react';

import { 
	Button,
	Dashicon,
} from '@wordpress/components';

interface UserLinkProps {
	url: string;
	alt: string;
	name: string;
}

export default function UserLink( props: UserLinkProps ) {
	return (
		<div>
			<Dashicon icon="admin-users" style={ { marginRight: '2px' } } />
			<b title={ props.alt }>
				<Button
					isLink
					href={ props.url }
				>
					<span>{ props.name ? props.name : 'Unknown' }</span>
				</Button>
			</b>
		</div>
	);
}
 

