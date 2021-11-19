import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../Interfaces';

import { 
	 Flex,
	 Dashicon,
} from '@wordpress/components';

interface PromiseParticipantsProps {
	promise: PromiseData;
}

interface PromiseParticipantsState {
	//
}

export class PromiseParticipants extends Component<PromiseParticipantsProps, PromiseParticipantsState> {

	constructor( props: PromiseParticipantsProps ) {
		super( props );
	}

	render() {
		return (
			<Flex gap={ 0 } align="center" justify="flex-start">
				<span>Participants: </span>
				<Dashicon icon="admin-users" />
				<strong>
					<a
						href={ `/tokenpass-user/${ this.props.promise.promise_meta?.source_user?.id }` }
					>
						{ this.props.promise?.promise_meta?.source_user?.name }
					</a>
				</strong>
				<Dashicon style={ { margin: '0 5px' } } icon="arrow-right-alt" />
				<Dashicon icon="admin-users" />
				<strong>
					<a
						href={ `/tokenpass-user/${this.props.promise?.promise_meta?.destination_user?.id}` }
					>
						{ this.props.promise?.promise_meta?.destination_user?.name }
					</a>
				</strong>
			</Flex>
		);
	}
}
 
