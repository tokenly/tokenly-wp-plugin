import * as React from 'react';
import { Component } from 'react';
import UserLink from './../UserLink';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

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
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: PromiseParticipantsProps ) {
		super( props );
	}

	render() {
		const balanceLink = `${this.adminPageUrl}${this.namespace}-token-balance-index`;
		return (
			<Flex>
				<span>Participants: </span>
				{ this.props.promise &&
					<Flex gap={ 0 } align="center" justify="flex-start">
						<UserLink
							url={ `${balanceLink}&user=${this.props.promise?.promise_meta?.source_user?.id}` }
							alt={ this.props?.promise?.source_id }
							name={ this.props?.promise?.promise_meta?.source_user?.name }
						/>
						<Dashicon style={ { margin: '0 5px' } } icon="arrow-right-alt" />
						<UserLink
							url={ `${balanceLink}&user=${this.props.promise?.promise_meta?.destination_user?.id}` }
							alt={ this.props?.promise?.destination }
							name={ this.props?.promise?.promise_meta?.destination_user?.name }
						/>
					</Flex>
				}
			</Flex>
		);
	}
}
 

