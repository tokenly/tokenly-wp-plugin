import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../../Interfaces';
import UserLink from './../UserLink';

import { 
	 Flex,
	 Dashicon,
} from '@wordpress/components';

interface PromiseParticipantsProps {
	promise: any;
}

interface PromiseParticipantsState {
	//
}

export default class PromiseParticipants extends Component<PromiseParticipantsProps, PromiseParticipantsState> {

	constructor( props: PromiseParticipantsProps ) {
		super( props );
	}

	render() {
		return (
			<Flex gap={ 0 } align="center" justify="flex-start">
				<span>Participants: </span>
				<UserLink
					id={ this.props.promise?.promise_meta?.source_user?.id }
					alt={ this.props?.promise?.source_id }
					name={ this.props?.promise?.promise_meta?.source_user?.name }
				/>
				<Dashicon style={ { margin: '0 5px' } } icon="arrow-right-alt" />
				<UserLink
					id={ this.props.promise?.promise_meta?.destination_user?.id }
					alt={ this.props?.promise?.destination }
					name={ this.props?.promise?.promise_meta?.destination_user?.name }
				/>
			</Flex>
		);
	}
}
 

