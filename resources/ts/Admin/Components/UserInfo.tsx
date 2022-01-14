import * as React from 'react';

import { 
	 Flex,
} from '@wordpress/components';

interface UserInfoProps {
	user: any;
}

export default function UserInfo( props: UserInfoProps ) {
	return (
		<Flex
			//@ts-ignore
			direction="column"
		>
			<div>Name: <b>{ props.user?.name } ({ props.user?.oauth_user?.username ?? '-' })</b></div>
		</Flex>
	);
}
 

