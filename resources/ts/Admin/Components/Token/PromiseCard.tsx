import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import { PromiseData } from '../../../Interfaces';
import PromiseLink from './PromiseLink';
import PromiseInfo from './PromiseInfo';
import CardActions from '../CardActions';

import { 
	Card,
	CardHeader,
	CardBody,
	CardFooter,
	Flex,
} from '@wordpress/components';

interface PromiseCardProps {
	promise: PromiseData;
}

export default function PromiseCard( props: PromiseCardProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	return (
		<Card size="extraSmall">
			<CardHeader>
				<Flex
					align="center"
					justify="flex-start"
				>
					<PromiseLink id={ props.promise.promise_id } />
					{ props?.promise?.pseudo == true &&
						<span>
							<span className="tokenly-component-chip">pseudo</span>
						</span>
					}
				</Flex>
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				<PromiseInfo promise={ props.promise } />
			</CardBody>
			<CardFooter>
				<CardActions actions={
					[
						{
							title: 'View Details',
							href: `${ adminPageUrl }${ namespace }-token-promise-show&promise=${props.promise.promise_id}`,
						},
						{
							title: 'Edit Promise',
							href: `${ adminPageUrl }${ namespace }-token-promise-edit&promise=${ props.promise.promise_id }`,
						}
					]
				}
				/>
			</CardFooter>
		</Card>
	);
}
 



