import * as React from 'react';
import { Component } from 'react';

import { 
	 Flex,
} from '@wordpress/components';

interface UserInfoProps {
	user: any;
}

interface UserInfoState {
	//
}

export default class UserInfo extends Component<UserInfoProps, UserInfoState> {

	constructor( props: UserInfoProps ) {
		super( props );
	}

	render() {
		return (
			<Flex
				//@ts-ignore
				direction="column"
			>
				<div>Name: <b>{ this.props.user?.name } ({ this.props.user?.oauth_user?.username ?? '-' })</b></div>
			</Flex>
		);
	}
}
 

