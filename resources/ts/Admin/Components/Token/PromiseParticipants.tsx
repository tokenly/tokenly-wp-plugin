import * as React from 'react';
import { Component } from 'react';
import UserLink from './../UserLink';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';

import { 
	 Flex,
	 Dashicon,
} from '@wordpress/components';

interface PromiseParticipantsProps {
	promise: any;
}

export default function PromiseParticipants( props: PromiseParticipantsProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	const balanceLink = `${adminPageUrl}${namespace}-user-token-balance-index`;
	return (
		<Flex>
			<span>Participants: </span>
			{ props.promise &&
				<Flex gap={ 0 } align="center" justify="flex-start">
					<UserLink
						url={ `${balanceLink}&id=${props.promise?.promise_meta?.source_user?.id}` }
						alt={ props?.promise?.source_id }
						name={ props?.promise?.promise_meta?.source_user?.name }
					/>
					<Dashicon style={ { margin: '0 5px' } } icon="arrow-right-alt" />
					<UserLink
						url={ `${balanceLink}&id=${props.promise?.promise_meta?.destination_user?.id}` }
						alt={ props?.promise?.destination }
						name={ props?.promise?.promise_meta?.destination_user?.name }
					/>
				</Flex>
			}
		</Flex>
	);
}
 

